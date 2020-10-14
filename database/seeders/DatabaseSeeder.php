<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') !== 'local' || env('APP_ENV') !== 'dev') {
            $this->call(CourseLocalSeeder::class);
            $this->call(SchoolLocalSeeder::class);
            $this->call(CoordinatorLocalSeeder::class);
            $this->call(StudentSeeder::class);
        }

        $this->call(GroupSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(HubLocalSeeder::class);
        $this->call(ProgramLocalSeeder::class);
    }
}
