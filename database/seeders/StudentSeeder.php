<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Student::first()) {
            $user = new User([
                'email' => 'student@test.com',
                'account_type' => 1,
            ]);
            $user->password = 'Password@123';
            $user->save();

            $userDetail = new UserDetail([
                'first_name' => 'Student',
                'last_name' => 'Mei',
                'middle_name' => 'Suk',
                'address' => 'La Marea, San Pedro Laguna',
                'birth_date' => '12/16/1997',
                'contact_number' => '9276637614',
            ]);
            $userDetail->user_id = $user->id;
            $userDetail->save();

            $student = new Student([
                'course_id' => 1,
                'school_id' => 1,
                'position' => 'Test Position',
            ]);

            $student->user_id = $user->id;
            $student->save();
            $student->student_number = $student->id;
            $student->save();
        }
    }
}
