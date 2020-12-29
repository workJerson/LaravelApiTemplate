<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class CourseLocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = [
            [
                'id' => 1,
                'name' => 'BA Political Science',
                'description' => 'BA Political Science',
                'program_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Bachelor of Public Administration',
                'description' => 'Bachelor of Public Administration',
                'program_id' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Executive Program',
                'description' => 'Executive Program',
                'program_id' => 1,
            ],

            [
                'id' => 4,
                'name' => 'Master in Public Administration (MPA)',
                'description' => 'Master in Public Administration (MPA)',
                'program_id' => 2,
            ],
            [
                'id' => 5,
                'name' => 'Master in Development and Management Governance (MDMG)',
                'description' => 'Master in Development and Management Governance (MDMG)',
                'program_id' => 2,
            ],
            [
                'id' => 6,
                'name' => 'Master of Management in Public Administration (MMPA)',
                'description' => 'Master of Management in Public Administration (MMPA)',
                'program_id' => 2,
            ],

            [
                'id' => 7,
                'name' => 'Doctor in Public Administration (DPA)',
                'description' => 'Doctor in Public Administration (DPA)',
                'program_id' => 3,
            ],
            [
                'id' => 8,
                'name' => 'Doctor in Philosophy (Ph.D)',
                'description' => 'Doctor in Philosophy (Ph.D)',
                'program_id' => 3,
            ],
            [
                'id' => 9,
                'name' => 'Executive Doctorate in Leadership (EDL)',
                'description' => 'Executive Doctorate in Leadership (EDL)',
                'program_id' => 3,
            ],
        ];

        foreach ($courses as $course) {
            $courseObject = Course::firstOrCreate(['id' => $course['id']], $course);
            if (!$courseObject->wasRecentlyCreated) {
                $courseObject->update(Arr::only($course, ['name', 'description', 'program_id']));
            }
        }
    }
}
