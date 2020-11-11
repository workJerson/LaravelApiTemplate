<?php

namespace Database\Seeders;

use App\Models\AdditionalCharge;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class AdditionalChargeLocalSeeder extends Seeder
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
                'description' => 'Action research',
                'program_id' => 1,
                'amount' => 2333.00,
            ],
            [
                'id' => 2,
                'description' => 'Action research',
                'program_id' => 1,
                'amount' => 2333.00,
            ],
            [
                'id' => 3,
                'description' => 'Action research',
                'program_id' => 1,
                'amount' => 2333.00,
            ],
            [
                'id' => 4,
                'description' => 'Policy Paper',
                'program_id' => 2,
                'amount' => 6000.00,
            ],
            [
                'id' => 5,
                'description' => 'Policy Paper',
                'program_id' => 2,
                'amount' => 6000.00,
            ],
            [
                'id' => 6,
                'description' => 'Policy Paper',
                'program_id' => 2,
                'amount' => 6000.00,
            ],
            [
                'id' => 7,
                'description' => 'Dissertion',
                'program_id' => 3,
                'amount' => 6000.00,
            ],
            [
                'id' => 8,
                'description' => 'Dissertion',
                'program_id' => 3,
                'amount' => 6000.00,
            ],
            [
                'id' => 9,
                'description' => 'Dissertion',
                'program_id' => 3,
                'amount' => 6000.00,
            ],
        ];

        foreach ($programs as $program) {
            $programObject = AdditionalCharge::firstOrCreate(['id' => $program['id']], $program);
            if (!$programObject->wasRecentlyCreated) {
                $programObject->update(Arr::only($program, ['name', 'description', 'amount']));
            }
        }
    }
}
