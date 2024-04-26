<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'subject teacher']);
        Role::create(['name' => 'class teacher']);
        Role::create(['name' => 'student']);


        Permission::create(['name' => 'manage dashboard']);
        Permission::create(['name' => 'manage registrations']);
        Permission::create(['name' => 'manage grades']);
        Permission::create(['name' => 'manage classes']);
        Permission::create(['name' => 'manage subjects']);
        Permission::create(['name' => 'manage classworks']);
        Permission::create(['name' => 'manage promotions']);
        Permission::create(['name' => 'manage attendances']);
        Permission::create(['name' => 'manage timetables']);
        Permission::create(['name' => 'manage exam marks']);
        Permission::create(['name' => 'manage academic year']);
        Permission::create(['name' => 'view exam marks']);
        Permission::create(['name' => 'edit classworks']);
        Permission::create(['name' => 'view classworks']);
        Permission::create(['name' => 'view timetables']);
        // Permission::create(['name' => 'edit classworks']);


        $admin = Role::findByName('admin');
        $admin->givePermissionTo([
            'manage dashboard',
            'manage registrations',
            'manage grades',
            'manage classes',
            'manage subjects',
            'manage promotions',
            'manage attendances',
            'manage classworks',
            'manage exam marks',
            'manage timetables',
            'manage academic year',
        ]);

        $subjectTeacher = Role::findByName('subject teacher');
        $subjectTeacher->givePermissionTo([
            'view timetables',
            'edit classworks'
        ]);

        $classTeacher = Role::findByName('class teacher');
        $classTeacher->givePermissionTo([
            'manage timetables',
            'manage promotions',
            'manage attendances',
            'manage exam marks',
        ]);

        $student = Role::findByName('student');
        $student->givePermissionTo([
            'view timetables',
            'view exam marks',
            'view classworks',
        ]);





        // $user = User::

        // $user = Auth::user()->user_type;

        // if($user == ''){
        //     $user->assignRole($admin);
        // }else if($user == 'teacher' && Auth::user()->teacher_type == 'subject'){
        //     $user->assignRole($subjectTeacher);
        // }else if($user == 'teacher' && Auth::user()->teacher_type == 'class'){
        //     $user->assignRole($classTeacher);
        // }
        // else if($user == 'student'){
        //     $user->assignRole($student);
        // }

    }
}
