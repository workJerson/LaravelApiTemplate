<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::firstOrCreate(
            [
                'id' => 1,
                'name' => 'superadmin',
                'description' => 'Allowed to do all.',
            ],
            [
                'id' => 2,
                'name' => 'admin',
                'description' => 'Admin process transactions',
            ]
        );
        Group::firstOrCreate(
            [
                'id' => 2,
                'name' => 'admin',
                'description' => 'Admin process transactions',
            ]
        );
    }
}
