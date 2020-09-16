<?php

namespace Database\Seeders;

use App\Models\Hub;
use Illuminate\Database\Seeder;

class HubLocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Hub::first()) {
            $data = [
                [
                    'name' => 'Bicol',
                    'description' => 'Bicol Hub',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                     'name' => 'Palawan',
                     'description' => 'Palawan Hub',
                     'created_at' => date('Y-m-d H:i:s'),
                     'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                     'name' => 'Cebu',
                     'description' => 'Cebu Hub',
                     'created_at' => date('Y-m-d H:i:s'),
                     'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                     'name' => 'Laguna',
                     'description' => 'Laguna Hub',
                     'created_at' => date('Y-m-d H:i:s'),
                     'updated_at' => date('Y-m-d H:i:s'),
                ],
            ];
            Hub::insert($data);
        }
    }
}
