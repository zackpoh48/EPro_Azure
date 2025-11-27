<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CountriesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Load JSON file
        $json = File::get(database_path('seeders/data/CountryCodes.json'));
        $countries = json_decode($json, true);

        // Insert into database
        foreach ($countries as $country) {
            DB::table('countries')->insert([
                'code' => $country['Code'],
                'name' => $country['Country'],   // use name instead of country
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
