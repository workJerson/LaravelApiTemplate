<?php

namespace Database\Seeders;

use App\Models\Coordinator;
use App\Models\User;
use Illuminate\Database\Seeder;

class CoordinatorLocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Coordinator::first()) {
            $user = new User([
                'email' => 'coordinator@test.com',
                'account_type' => 2,
            ]);
            $user->password = 'Password@123';
            $user->save();

            $coordinator = new Coordinator([
                'hub_id' => 1,
            ]);
            $coordinator->user_id = $user->id;
            $coordinator->save();
        }
    }
}
