<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!$this->organizationExists()) {
            Organization::create([
                "unique_id" => "0a4cb00a-b3d3-ee11-904f-6045bde9b674",
                "name" => "CRONUS AU",
                "send_registration_email" => 1,
                "logo_url" => "https://eprocure.squincy.com/assets/images/logo_with_text.png"
                // "nav_username" => "CRONUSAU",
                // "nav_password" => "sE*c,P<2%Q>Z%(RB",
                // "nav_auth" => "ntlm",
                // "nav_server" => "https://api.businesscentral.dynamics.com/",
                // "nav_port" => "7247",
                // "nav_environment" => "CRONUSAU",
                // "nav_company" => "Leisure%20Farm%20Corp.%20Sdn%20Bhd.",
            ]);
        } else {
            $organization = Organization::whereName("CRONUS AU")->first();
            $organization->nav_username = "CRONUSAU";
            $organization->nav_password = "sE*c,P<2%Q>Z%(RB";
            $organization->nav_auth = "ntlm";
            $organization->nav_server = "https://api.businesscentral.dynamics.com/";
            $organization->nav_port = "7247";
            $organization->nav_environment = "CRONUSAU";
            $organization->nav_company = "Leisure%20Farm%20Corp.%20Sdn%20Bhd.";
            $organization->save();
        }
    }

    protected function organizationExists()
    {
        return Organization::whereName("CRONUS AU")->exists();
    }
}
