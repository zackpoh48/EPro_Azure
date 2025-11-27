<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!$this->adminExists()) {
            Admin::create([
                "name" => "Admin",
                "email" => "admin@admin.com",
                "password" => bcrypt("1234"),
            ]);
        }
    }

    protected function adminExists()
    {
        return Admin::whereName("Admin")->exists();
    }
}
