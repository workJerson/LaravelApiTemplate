<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseLocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Course::first()) {
            $data = [
            [
                'name' => 'Development Management',
                'description' => 'Development Management Course',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                 'name' => 'Public Administration',
                 'description' => 'Public Administration Description',
                 'created_at' => date('Y-m-d H:i:s'),
                 'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                 'name' => 'Administration/Public Management',
                 'description' => 'Administration/Public Management Description',
                 'created_at' => date('Y-m-d H:i:s'),
                 'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
            Course::insert($data);
        }
    }
}
