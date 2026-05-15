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
$dryRun     = false;  // set true to preview without saving to DB
$batchSize  = 10;     // pause every N rows to avoid rate limiting
$backupFile = __DIR__ . '/product_tests_backup.json';

// ═══════════════════════════════════════════════════════════════
//  STEP 1 — Fetch product tests
// ═══════════════════════════════════════════════════════════════
echo "\n📦 Step 1/3 — Fetching product tests...\n";

$rows  = $pdo->query("SELECT id, name, data FROM product_tests")
             ->fetchAll(PDO::FETCH_ASSOC);
$total = count($rows);

echo "   Found: $total product tests\n";

// Save backup before touching anything
file_put_contents($backupFile, json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "   ✅ Backup saved → $backupFile\n";

// ═══════════════════════════════════════════════════════════════
//  STEP 2 — Translate & Update
// ═══════════════════════════════════════════════════════════════
echo "\n🌐 Step 2/3 — Translating (de → en)...\n";
if ($dryRun) echo "   ⚠️  DRY RUN — DB will NOT be updated\n";
echo "\n";

$update = $pdo->prepare("UPDATE product_tests SET name = ?, data = ? WHERE id = ?");

$done   = 0;
$failed = 0;

foreach ($rows as $row) {
    $id   = $row['id'];
    $name = $row['name'];
    $data = $row['data'] ? json_decode($row['data'], true) : null;

    // ── Translate name ──────────────────────────────────────────
    $translatedName = googleTranslate($name, 'en', 'de');
    if ($translatedName === null) {
        echo "   ⚠️  Name FAILED [id=$id]: $name\n";
        $translatedName = $name;
        $failed++;
    }

    // ── Translate each value in the data JSON array ─────────────
    // data is a key=>value map; keys are attribute labels (kept as-is),
    // values are the test results/readings that need translation.
    $translatedData = null;
    if (is_array($data)) {
        $translatedData = [];
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $translatedValue = googleTranslate($value, 'en', 'de');
                if ($translatedValue === null) {
                    echo "   ⚠️  Data value FAILED [id=$id] key=$key: $value\n";
                    $translatedValue = $value;
                    $failed++;
                }
                $translatedData[$key] = $translatedValue;
            } else {
                // Non-string values (numbers, booleans) are kept as-is
                $translatedData[$key] = $value;
            }
        }
    }

    $translatedDataJson = $translatedData !== null
        ? json_encode($translatedData, JSON_UNESCAPED_UNICODE)
        : $row['data'];

    $done++;
    echo "   [$done/$total] id=$id => $translatedName\n";

    if (!$dryRun) {
        $update->execute([$translatedName, $translatedDataJson, $id]);
    }

    // Rate limit: pause every $batchSize rows
    if ($done % $batchSize === 0) {
        sleep(1);
    }
}

// ═══════════════════════════════════════════════════════════════
//  SUMMARY
// ═══════════════════════════════════════════════════════════════
echo "\n════════════════════════════════\n";
echo "✅ Done!\n";
echo "   Total    : $total\n";
echo "   Updated  : " . ($done - $failed) . "\n";
echo "   Failed   : $failed\n";
echo "   Backup   : $backupFile\n";
echo "   DB saved : " . ($dryRun ? 'No (dry run)' : 'Yes') . "\n";
echo "════════════════════════════════\n\n";


// ═══════════════════════════════════════════════════════════════
//  GOOGLE TRANSLATE — free endpoint, no API key needed
// ═══════════════════════════════════════════════════════════════
function googleTranslate(?string $text, string $targetLang, string $sourceLang = 'auto'): ?string
{
    if (empty(trim((string) $text))) return $text;

    // Protect placeholders like :attribute, :name, {value} so
    // Google does not translate them
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

    // Collect all translated parts
    $result = '';
    foreach ($data[0] as $part) {
        if (isset($part[0])) $result .= $part[0];
    }

    $result = trim($result);
    if (!$result) return null;

    // Restore original placeholders
    foreach ($placeholders as $token => $original) {
        $result = str_replace($token, $original, $result);
    }

    return $result;
}
