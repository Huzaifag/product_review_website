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
$dryRun = false; // set true to preview without saving

// ═══════════════════════════════════════════════════════════════
//  SLUG GENERATOR
// ═══════════════════════════════════════════════════════════════
function makeSlug(string $name): string
{
    // Lowercase
    $slug = mb_strtolower($name, 'UTF-8');

    // Replace common special chars / accents with ascii equivalents
    $slug = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $slug);

    // Replace anything that's not a letter, number, or space with space
    $slug = preg_replace('/[^a-z0-9\s-]/', ' ', $slug);

    // Replace whitespace and multiple dashes with a single dash
    $slug = preg_replace('/[\s-]+/', '-', trim($slug));

    return $slug;
}

// ═══════════════════════════════════════════════════════════════
//  GENERIC TABLE UPDATER
// ═══════════════════════════════════════════════════════════════
function updateSlugs(PDO $pdo, string $table, bool $dryRun): void
{
    echo "\n────────────────────────────────────────\n";
    echo "📋 Table: $table\n";
    echo "────────────────────────────────────────\n";

    $rows = $pdo->query("SELECT id, name, slug FROM `$table`")
                ->fetchAll(PDO::FETCH_ASSOC);

    $total   = count($rows);
    $updated = 0;
    $skipped = 0;

    echo "   Found: $total rows\n\n";

    $stmt = $pdo->prepare("UPDATE `$table` SET slug = ? WHERE id = ?");

    foreach ($rows as $row) {
        $id      = $row['id'];
        $name    = $row['name'] ?? '';
        $oldSlug = $row['slug'] ?? '';
        $newSlug = makeSlug($name);

        if ($newSlug === $oldSlug) {
            $skipped++;
            continue; // no change needed
        }

        echo "   id=$id\n";
        echo "      name : $name\n";
        echo "      old  : $oldSlug\n";
        echo "      new  : $newSlug\n";

        if (!$dryRun) {
            $stmt->execute([$newSlug, $id]);
            echo "      ✅ Updated\n";
        } else {
            echo "      👁  (dry run — not saved)\n";
        }

        $updated++;
    }

    echo "\n   Done → Updated: $updated | Skipped (no change): $skipped | Total: $total\n";
}

// ═══════════════════════════════════════════════════════════════
//  RUN FOR ALL TABLES
// ═══════════════════════════════════════════════════════════════
echo "\n🔧 Slug Updater\n";
if ($dryRun) echo "⚠️  DRY RUN — DB will NOT be updated\n";

updateSlugs($pdo, 'products',       $dryRun);
updateSlugs($pdo, 'categories',     $dryRun);
updateSlugs($pdo, 'sub_categories', $dryRun);

echo "\n════════════════════════════════\n";
echo "✅ All done!\n";
echo "   DB saved : " . ($dryRun ? 'No (dry run)' : 'Yes') . "\n";
echo "════════════════════════════════\n\n";
