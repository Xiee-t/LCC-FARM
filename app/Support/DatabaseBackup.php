<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use RuntimeException;

class DatabaseBackup
{
    public function create(): string
    {
        $connection = DB::connection();
        $driver = $connection->getDriverName();

        if ($driver !== 'mysql') {
            throw new RuntimeException("Database backups are only configured for MySQL. Current driver: {$driver}.");
        }

        $directory = storage_path('app/backups');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $database = $connection->getDatabaseName();
        $filename = sprintf('%s_%s.sql', $database, now()->format('Y-m-d_His'));
        $path = $directory . DIRECTORY_SEPARATOR . $filename;

        file_put_contents($path, $this->mysqlDump($database));

        return $path;
    }

    public function files(): array
    {
        $directory = storage_path('app/backups');

        if (! is_dir($directory)) {
            return [];
        }

        $files = glob($directory . DIRECTORY_SEPARATOR . '*.sql') ?: [];
        rsort($files);

        return $files;
    }

    private function mysqlDump(string $database): string
    {
        $pdo = DB::connection()->getPdo();
        $tables = DB::select("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'");
        $dump = [
            '-- LCC Farm Eggs database backup',
            '-- Created at: ' . now()->toDateTimeString(),
            'SET FOREIGN_KEY_CHECKS=0;',
            '',
        ];

        foreach ($tables as $tableRow) {
            $table = array_values((array) $tableRow)[0];
            $quotedTable = $this->quoteIdentifier($table);
            $createRow = DB::selectOne('SHOW CREATE TABLE ' . $quotedTable);
            $createTable = $createRow->{'Create Table'};

            $dump[] = 'DROP TABLE IF EXISTS ' . $quotedTable . ';';
            $dump[] = $createTable . ';';
            $dump[] = '';

            DB::table($table)->orderByRaw('1')->chunk(200, function ($rows) use (&$dump, $pdo, $quotedTable) {
                foreach ($rows as $row) {
                    $columns = array_keys((array) $row);
                    $values = array_map(fn ($value) => $this->quoteValue($pdo, $value), array_values((array) $row));

                    $dump[] = sprintf(
                        'INSERT INTO %s (%s) VALUES (%s);',
                        $quotedTable,
                        implode(', ', array_map(fn ($column) => $this->quoteIdentifier($column), $columns)),
                        implode(', ', $values)
                    );
                }
            });

            $dump[] = '';
        }

        $dump[] = 'SET FOREIGN_KEY_CHECKS=1;';
        $dump[] = '';

        return implode(PHP_EOL, $dump);
    }

    private function quoteIdentifier(string $identifier): string
    {
        return '`' . str_replace('`', '``', $identifier) . '`';
    }

    private function quoteValue(\PDO $pdo, mixed $value): string
    {
        if ($value === null) {
            return 'NULL';
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        return $pdo->quote((string) $value);
    }
}
