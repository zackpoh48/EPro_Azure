<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
        public function run(): void
        {
            $rows = [
                ['code' => '01', 'name' => 'Johor'],
                ['code' => '02', 'name' => 'Kedah'],
                ['code' => '03', 'name' => 'Kelantan'],
                ['code' => '04', 'name' => 'Melaka'],
                ['code' => '05', 'name' => 'Negeri Sembilan'],
                ['code' => '06', 'name' => 'Pahang'],
                ['code' => '07', 'name' => 'Pulau Pinang'],
                ['code' => '08', 'name' => 'Perak'],
                ['code' => '09', 'name' => 'Perlis'],
                ['code' => '10', 'name' => 'Selangor'],
                ['code' => '11', 'name' => 'Terengganu'],
                ['code' => '12', 'name' => 'Sabah'],
                ['code' => '13', 'name' => 'Sarawak'],
                ['code' => '14', 'name' => 'Kuala Lumpur'],
                ['code' => '15', 'name' => 'Labuan'],
                ['code' => '16', 'name' => 'Putrajaya'],
                ['code' => '17', 'name' => 'Not Applicable'],
            ];

        // If your states table has no timestamps, remove created_at/updated_at above and change the upsert columns accordingly.
        DB::table('states')->upsert(
            $rows,
            ['code'],                     // conflict target (requires PK/unique index on code)
            ['name']        // columns to update on conflict
        );
    }
}
