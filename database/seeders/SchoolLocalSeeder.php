<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolLocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!School::first()) {
            $data = [
            [
                'name' => 'STI (Tanay)',
                'address' => 'Tanay, Rizal',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 1,
            ],
            [
                'name' => 'Polytechnic University of the Philippines (Santa Rosa)',
                'address' => 'Santa Rosa, Laguna',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 1,
            ],
            [
                'name' => 'University of the Philippines',
                'address' => 'Los Banos, Laguna',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 1,
            ],
        ];
            School::insert($data);
        }
    }
}
