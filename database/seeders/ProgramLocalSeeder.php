<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramLocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Program::first()) {
            $data = [
                [
                    'name' => 'Baccalaureate',
                    'description' => 'Baccalaureate Program',
                    'total_price' => 7500.00,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'Masters',
                    'description' => 'Masters Program',
                    'total_price' => 7500.00,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'Doctoral',
                    'description' => 'Doctoral Program',
                    'total_price' => 7500.00,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ];
            Program::insert($data);
        }
    }
}
