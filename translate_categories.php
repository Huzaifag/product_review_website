<?php

// ═══════════════════════════════════════════════════════════════
//  DB CONFIG
// ═══════════════════════════════════════════════════════════════
$host = 'localhost';
$db   = 'okotest';
$user = 'okotest';
$pass = 'BYbBSJpbr6T4pzGa';

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ═══════════════════════════════════════════════════════════════
//  CONFIG
// ═══════════════════════════════════════════════════════════════
$dryRun     = false;
$batchSize  = 10;
$backupFile = __DIR__ . '/categories_backup.json';

// ═══════════════════════════════════════════════════════════════
//  STEP 1 — Fetch all categories
// ═══════════════════════════════════════════════════════════════
echo "\n📦 Step 1/3 — Fetching categories...\n";

$rows  = $pdo->query("SELECT id, name, description, guide FROM categories")
             ->fetchAll(PDO::FETCH_ASSOC);
$total = count($rows);

echo "   Found: $total categories\n";

// Backup original data before touching anything
file_put_contents($backupFile, json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "   ✅ Backup saved → $backupFile\n";

// ═══════════════════════════════════════════════════════════════
//  STEP 2 — Translate name, description & guide
// ═══════════════════════════════════════════════════════════════
echo "\n🌐 Step 2/3 — Translating (de → en)...\n";
if ($dryRun) echo "   ⚠️  DRY RUN — DB will NOT be updated\n";
echo "\n";

$update = $pdo->prepare("UPDATE categories SET name = ?, description = ?, guide = ? WHERE id = ?");

$done   = 0;
$failed = 0;

foreach ($rows as $row) {
    $id   = $row['id'];
    echo "   ── Category id=$id ──────────────────────────\n";

    // ── name ───────────────────────────────────────────────────
    $translatedName = googleTranslate($row['name'], 'en', 'de');
    if ($translatedName === null) {
        echo "      ⚠️  name FAILED — keeping original\n";
        $translatedName = $row['name'];
        $failed++;
    } else {
        echo "      ✅ name: $translatedName\n";
    }

    // ── description ────────────────────────────────────────────
    $translatedDesc = googleTranslate($row['description'], 'en', 'de');
    if ($translatedDesc === null) {
        echo "      ⚠️  description FAILED — keeping original\n";
        $translatedDesc = $row['description'];
        $failed++;
    } else {
        echo "      ✅ description: " . mb_substr($translatedDesc, 0, 80) . "...\n";
    }

    // ── guide (JSON array of strings) ──────────────────────────
    $translatedGuide = $row['guide']; // default: keep original

    if (!empty($row['guide']) && $row['guide'] !== '[]') {
        $guideItems = json_decode($row['guide'], true);

        if (is_array($guideItems)) {
            $translatedItems = [];
            foreach ($guideItems as $index => $item) {
                $translatedItem = googleTranslate($item, 'en', 'de');
                if ($translatedItem === null) {
                    echo "      ⚠️  guide[$index] FAILED — keeping original\n";
                    $translatedItems[] = $item;
                    $failed++;
                } else {
                    echo "      ✅ guide[$index]: " . mb_substr($translatedItem, 0, 80) . "...\n";
                    $translatedItems[] = $translatedItem;
                }
                usleep(80000); // 80ms between each guide item
            }
            $translatedGuide = json_encode($translatedItems, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            echo "      ⚠️  guide is not valid JSON — skipping guide translation\n";
        }
    } else {
        echo "      ℹ️  guide is empty — skipping\n";
    }

    // ── Update DB ───────────────────────────────────────────────
    if (!$dryRun) {
        $update->execute([$translatedName, $translatedDesc, $translatedGuide, $id]);
    }

    $done++;

    // Rate limit pause every batch
    if ($done % $batchSize === 0) {
        echo "\n   ⏸️  Pausing 1s (rate limit)...\n\n";
        sleep(1);
    }
}

// ═══════════════════════════════════════════════════════════════
//  SUMMARY
// ═══════════════════════════════════════════════════════════════
echo "\n════════════════════════════════\n";
echo "✅ Done!\n";
echo "   Total categories : $total\n";
echo "   Processed        : $done\n";
echo "   Failed fields    : $failed\n";
echo "   Backup           : $backupFile\n";
echo "   DB saved         : " . ($dryRun ? 'No (dry run)' : 'Yes') . "\n";
echo "════════════════════════════════\n\n";


// ═══════════════════════════════════════════════════════════════
//  GOOGLE TRANSLATE — free endpoint, no API key needed
// ═══════════════════════════════════════════════════════════════
function googleTranslate(?string $text, string $targetLang, string $sourceLang = 'auto'): ?string
{
    if (empty(trim((string) $text))) return $text;

    // Protect placeholders like :attribute, {value} from being translated
    $placeholders = [];
    $protected = preg_replace_callback(
        '/(:([a-zA-Z_]+)|\{[a-zA-Z_]+\})/',
        function ($m) use (&$placeholders) {
            $token = '##' . count($placeholders) . '##';
            $placeholders[$token] = $m[0];
            return $token;
        },
        $text
    );

    $url = 'https://translate.googleapis.com/translate_a/single'
         . '?client=gtx'
         . '&sl=' . urlencode($sourceLang)
         . '&tl=' . urlencode($targetLang)
         . '&dt=t'
         . '&q='  . urlencode($protected);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT      => 'Mozilla/5.0',
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 || !$response) return null;

    $data = json_decode($response, true);
    if (!isset($data[0]))                return null;

    $result = '';
    foreach ($data[0] as $part) {
        if (isset($part[0])) $result .= $part[0];
    }

    $result = trim($result);
    if (!$result) return null;

    // Restore placeholders
    foreach ($placeholders as $token => $original) {
        $result = str_replace($token, $original, $result);
    }

    return $result;
}