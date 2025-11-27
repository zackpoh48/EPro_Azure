<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MsicCodesSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/MSICSubCategoryCodes.json');

        if (!File::exists($path)) {
            $this->command->error("File not found: {$path}");
            return;
        }

        $json = File::get($path);
        $items = json_decode($json, true);

        if (!is_array($items)) {
            $this->command->error("Invalid JSON in {$path}");
            return;
        }

        $now = now();
        $rows = [];

        foreach ($items as $it) {
            $code = trim((string)($it['Code'] ?? ''));
            if ($code === '') {
                continue; // skip invalid rows
            }

            $description = trim((string)($it['Description'] ?? ''));
            $category = trim((string)($it['MSIC Category Reference'] ?? ''));

            $rows[] = [
                'code'        => $code,
                // change 'description' to your actual column name if different
                'description' => $description,
                'category'    => $category !== '' ? $category : null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        // Upsert avoids duplicates (e.g., repeated codes in the JSON)
        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('msic_codes')->upsert(
                $chunk,
                ['code'],                             // unique key
                ['description', 'category', 'updated_at']  // columns to update on conflict
            );
        }

        $this->command->info('MSIC codes seeded: ' . count($rows));
    }
}
