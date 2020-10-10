<?php

namespace Database\Seeders;

use App\Models\CmsProfile;
use App\Models\Group;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!CmsProfile::first()) {
            $user = new User([
                'email' => 'superadmin@test.com',
                'account_type' => 3,
            ]);
            $user->password = 'Password@123';
            $user->save();

            $userDetail = new UserDetail([
                'first_name' => 'Admin',
                'last_name' => 'Mei',
                'middle_name' => 'Suk',
                'address' => 'La Marea, San Pedro Laguna',
                'birth_date' => '12/16/1997',
                'contact_number' => '9276637614',
            ]);
            $userDetail->user_id = $user->id;
            $userDetail->save();

            $cmsProfile = new CmsProfile([
                'group_id' => Group::where('name', 'superadmin')->first()->id,
            ]);
            $cmsProfile->user_id = $user->id;
            $cmsProfile->save();
        }
    }
}
