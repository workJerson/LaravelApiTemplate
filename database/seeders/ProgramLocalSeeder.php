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
                'course' => 'BA Political Science',
                'total_price' => 83000.00,
            ],
            [
                'id' => 2,
                'name' => 'Baccalaureate',
                'course' => 'Bachelor of Public Administration',
                'total_price' => 83000.00,
            ],
            [
                'id' => 3,
                'name' => 'Baccalaureate',
                'course' => 'Executive Program',
                'total_price' => 83000.00,
            ],
            [
                'id' => 4,
                'name' => 'Masters',
                'course' => 'Master in Public Administration (MPA)',
                'total_price' => 104000.00,
            ],
            [
                'id' => 5,
                'name' => 'Masters',
                'course' => 'Master in Development and Management Governance (MDMG)',
                'total_price' => 104000.00,
            ],
            [
                'id' => 6,
                'name' => 'Masters',
                'course' => 'Master of Management in Public Administration (MMPA)',
                'total_price' => 104000.00,
            ],
            [
                'id' => 7,
                'name' => 'Doctoral',
                'course' => 'Doctor in Public Administration (DPA)',
                'total_price' => 155000.00,
            ],
            [
                'id' => 8,
                'name' => 'Doctoral',
                'course' => 'Doctor in Philosophy (Ph.D)',
                'total_price' => 155000.00,
            ],
            [
                'id' => 9,
                'name' => 'Doctoral',
                'course' => 'Executive Doctorate in Leadership (EDL)',
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
