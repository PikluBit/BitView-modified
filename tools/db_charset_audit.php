<?php
// db_charset_audit.php
// Small readonly audit script to detect charset/collation mismatches
// Usage (browser): http://your-site/tools/db_charset_audit.php
// Usage (cli): php tools/db_charset_audit.php

declare(strict_types=1);

header('Content-Type: text/plain; charset=utf-8');

require_once __DIR__ . '/../_includes/_classes/DB.class.php';

$db = new DB();
// DB constructor does not return connection status; we proceed and rely on execute() errors to be logged.

$schema = 'bitview'; // update if your DB name differs

echo "Database charset/collation audit for schema: $schema\n";
echo "-------------------------------------------------\n\n";

// 1) Columns not using utf8mb4
$sql_columns = "SELECT TABLE_NAME, COLUMN_NAME, CHARACTER_SET_NAME, COLLATION_NAME, DATA_TYPE
FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA = :SCHEMA
  AND CHARACTER_SET_NAME IS NOT NULL
  AND CHARACTER_SET_NAME != 'utf8mb4'
ORDER BY TABLE_NAME, COLUMN_NAME";

$cols = $db->execute($sql_columns, false, [':SCHEMA' => $schema], false);

if (empty($cols)) {
    echo "No columns with non-utf8mb4 character sets found.\n";
} else {
    echo "Columns not using utf8mb4:\n";
    foreach ($cols as $c) {
        echo " - {$c['TABLE_NAME']}.{$c['COLUMN_NAME']} (type={$c['DATA_TYPE']}) charset={$c['CHARACTER_SET_NAME']} collation={$c['COLLATION_NAME']}\n";
    }
}

// 2) Tables with non-utf8mb4 default collation
$sql_tables = "SELECT TABLE_NAME, TABLE_COLLATION
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = :SCHEMA
  AND (TABLE_COLLATION IS NULL OR TABLE_COLLATION NOT LIKE 'utf8mb4%')
ORDER BY TABLE_NAME";

$tables = $db->execute($sql_tables, false, [':SCHEMA' => $schema], false);

if (empty($tables)) {
    echo "\nAll table default collations begin with utf8mb4.\n";
} else {
    echo "\nTables with non-utf8mb4 default collations:\n";
    foreach ($tables as $t) {
        echo " - {$t['TABLE_NAME']} (collation={$t['TABLE_COLLATION']})\n";
    }
}

// 3) FULLTEXT indexes
$sql_fulltext = "SELECT TABLE_NAME, INDEX_NAME, GROUP_CONCAT(COLUMN_NAME ORDER BY SEQ_IN_INDEX) AS columns
FROM information_schema.STATISTICS
WHERE TABLE_SCHEMA = :SCHEMA
  AND INDEX_TYPE = 'FULLTEXT'
GROUP BY TABLE_NAME, INDEX_NAME
ORDER BY TABLE_NAME";

$fts = $db->execute($sql_fulltext, false, [':SCHEMA' => $schema], false);

if (empty($fts)) {
    echo "\nNo FULLTEXT indexes found.\n";
} else {
    echo "\nFULLTEXT indexes found:\n";
    foreach ($fts as $f) {
        echo " - {$f['TABLE_NAME']}.{$f['INDEX_NAME']} (columns: {$f['columns']})\n";
    }
}

// 4) Suggested ALTER statements for tables
$convert_statements = [];
if (!empty($tables)) {
    foreach ($tables as $t) {
        $convert_statements[] = "ALTER TABLE `{$t['TABLE_NAME']}` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;";
    }
}

if (!empty($convert_statements)) {
    echo "\nSuggested permanent conversion commands (run in mysql/phpMyAdmin):\n";
    echo "ALTER DATABASE `{$schema}` CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;\n";
    foreach ($convert_statements as $s) {
        echo $s . "\n";
    }
    echo "\nNotes:\n";
    echo " - Run the ALTER DATABASE first, then each ALTER TABLE.\n";
    echo " - If you have FULLTEXT indexes, DROP and re-CREATE them after conversion.\n";
    echo " - Restart MySQL/Apache if you still see charset/collation caching issues.\n";
} else {
    echo "\nNo table-level conversion statements suggested (tables already utf8mb4).\n";
    echo "If you're still getting COLLATION errors, inspect the 'Columns not using utf8mb4' list above.\n";
}

echo "\nNext steps (recommended):\n";
echo " 1) Run this script and follow the suggested ALTER statements.\n";
echo " 2) If you have FULLTEXT indexes (e.g., on 'videos.tags'), DROP and re-CREATE them after conversion.\n";
echo " 3) Verify database default: SHOW CREATE DATABASE `{$schema}`; and connection charset (PDO DSN 'charset' option is already used).\n";
echo " 4) After conversion, retry the search that triggered the error.\n";

exit(0);
