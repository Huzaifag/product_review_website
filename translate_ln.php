<?php

// DB Config
$host = 'localhost';
$db   = 'okotest';
$user = 'okotest';
$pass = 'BYbBSJpbr6T4pzGa';

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch only untranslated ln rows (value = key)
$rows = $pdo->query("SELECT id, `key`, `value` FROM translates WHERE lang='nl' AND `value` = `key`")->fetchAll(PDO::FETCH_ASSOC);

$total = count($rows);
echo "Found $total untranslated rows\n";

$update = $pdo->prepare("UPDATE translates SET `value` = ? WHERE id = ?");

$done = 0;
$failed = 0;
$batchSize = 10; // pause every 10 requests to avoid rate limiting

foreach ($rows as $i => $row) {
    $text = $row['value'];
    $id   = $row['id'];

    // Skip empty values
    if (empty(trim($text))) {
        continue;
    }

    // Preserve Laravel placeholders like :attribute, :date, :value etc
    // Replace them temporarily so Google doesn't translate them
    $placeholders = [];
    $protected = preg_replace_callback('/:([a-zA-Z_]+)/', function($m) use (&$placeholders) {
        $token = '##' . count($placeholders) . '##';
        $placeholders[$token] = $m[0];
        return $token;
    }, $text);

    $translated = googleTranslate($protected, 'nl');

    if ($translated === null) {
        echo "FAILED [id=$id]: $text\n";
        $failed++;
        sleep(2);
        continue;
    }

    // Restore placeholders
    foreach ($placeholders as $token => $original) {
        $translated = str_replace($token, $original, $translated);
    }

    $update->execute([$translated, $id]);
    $done++;

    echo "[{$done}/{$total}] id=$id => $translated\n";

    // Rate limit pause every batch
    if ($done % $batchSize === 0) {
        sleep(1);
    }
}

echo "\n✅ Done! Translated: $done | Failed: $failed | Skipped (manual): " . (2236 - $total) . "\n";

// -------------------------------------------------------
function googleTranslate(string $text, string $targetLang): ?string
{
    $url = 'https://translate.googleapis.com/translate_a/single'
        . '?client=gtx'
        . '&sl=en'
        . '&tl=' . urlencode($targetLang)
        . '&dt=t'
        . '&q=' . urlencode($text);

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

    if ($httpCode !== 200 || !$response) {
        return null;
    }

    $data = json_decode($response, true);

    if (!isset($data[0])) {
        return null;
    }

    // Collect all translation parts
    $result = '';
    foreach ($data[0] as $part) {
        if (isset($part[0])) {
            $result .= $part[0];
        }
    }

    return trim($result) ?: null;
}
