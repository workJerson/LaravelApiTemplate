<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProgramLocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programs = [
            [
                'id' => 1,
                'name' => 'Baccalaureate',
                'course' => 'Baccalaureate Program',
                'total_price' => 84999.00,
            ],
            [
                'id' => 2,
                'name' => 'Masters',
                'course' => 'Masters Program',
                'total_price' => 103996.00,
            ],
            [
                'id' => 3,
                'name' => 'Doctoral',
                'course' => 'Doctoral Program',
                'total_price' => 155000.00,
            ],
        ];

        foreach ($programs as $program) {
            $programObject = Program::firstOrCreate(['id' => $program['id']], $program);
            if (!$programObject->wasRecentlyCreated) {
                $programObject->update(Arr::only($program, ['name', 'course', 'total_price']));
            }
        }
    }
}
