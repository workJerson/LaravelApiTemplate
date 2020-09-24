<?php

namespace Database\Seeders;

use App\Models\Coordinator;
use App\Models\User;
use App\Models\UserDetail;
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
                'email' => 'coordinator1@test.com',
                'account_type' => 2,
            ]);
            $user->password = 'Password@123';
            $user->save();

            $userDetail = new UserDetail([
                'first_name' => 'Suk',
                'last_name' => 'Kuk',
                'middle_name' => 'Mei',
                'address' => 'La Marea, San Pedro Laguna',
                'birth_date' => '12/16/1997',
                'contact_number' => '9276637614',
            ]);
            $userDetail->user_id = $user->id;
            $userDetail->save();

            $coordinator = new Coordinator([
                'hub_id' => 1,
            ]);
            $coordinator->user_id = $user->id;
            $coordinator->save();
        }
    }
}
