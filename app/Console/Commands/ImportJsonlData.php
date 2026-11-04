<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use SplFileObject;

class ImportJsonlData extends Command
{
    // Wir nehmen den Dateinamen und den Tabellennamen als flexible Argumente entgegen
    protected $signature = 'db:import-jsonl {file?} {table?}';

    protected $description = 'Importiert generische Zutaten aus einer .jsonl Datei in die SQLite/MySQL Datenbank';

    public function handle(): int
    {
        // Standardpfad auf deine neue generische JSONL-Datei anpassen
        $filePath = $this->argument('file') ?? '/Users/stefano/Sites/mealplannertryingfeatures/generic_ingredients.jsonl';
        $tableName = $this->argument('table') ?? 'o_f_f_ingredients';

        if (! file_exists($filePath)) {
            $this->error("Die Datei existiert nicht unter: {$filePath}");

            return 1;
        }

        $this->info("Starte Import von {$filePath} in Tabelle '{$tableName}' (SQLite aktiv)...");

        $file = new SplFileObject($filePath, 'r');
        $file->setFlags(SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);

        $batch = [];
        $batchSize = 500;
        $count = 0;

        $bar = $this->output->createProgressBar();
        $bar->start();

        foreach ($file as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            $row = json_decode($line, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($row)) {

                $timestamps = [
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if ($tableName === 'u_s_d_a_ingredients') {
                    if (! isset($row['fdc_id'])) {
                        $bar->advance();

                        continue;
                    }

                    $flattenedData = [
                        'fdc_id' => $row['fdc_id'],
                        'names' => json_encode($row['names'] ?? []),
                        'nutriments' => json_encode($row['nutriments_per_100g'] ?? []),
                        ...$timestamps,
                    ];
                    $uniqueBy = ['fdc_id'];
                    $updateColumns = ['names', 'nutriments', 'updated_at'];
                } else {
                    $flattenedData = [
                        'barcode' => $row['barcode'] ?? null,
                        'names' => json_encode($row['names'] ?? []),
                        'nutriments' => json_encode($row['nutriments_per_100g'] ?? []),
                        ...$timestamps,
                    ];
                    $uniqueBy = ['barcode'];
                    $updateColumns = ['names', 'nutriments', 'updated_at'];
                }

                $batch[] = $flattenedData;
                $count++;

                if (count($batch) >= $batchSize) {
                    DB::table($tableName)->upsert(
                        $batch,
                        $uniqueBy,
                        $updateColumns
                    );
                    $batch = [];
                }
            }
            $bar->advance();
        }

        if (! empty($batch)) {
            DB::table($tableName)->upsert(
                $batch,
                $uniqueBy,
                $updateColumns
            );
        }

        $bar->finish();
        $this->newLine();
        $this->info("Erfolgreich {$count} generische Zutaten importiert!");

        return 0;
    }
}
