<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        Role::create(['name' => 'teacher']);
        Role::create(['name' => 'student']);


        Permission::create(['name' => 'manage registrations']);
        Permission::create(['name' => 'manage grades']);
        Permission::create(['name' => 'manage classes']);
        Permission::create(['name' => 'manage curriculums']);
        Permission::create(['name' => 'manage classworks']);
        Permission::create(['name' => 'manage exams']);

        // Assign Permissions to Roles
        $admin = Role::findByName('admin');
        $admin->givePermissionTo([
            'manage registrations',
            'manage grades',
            'manage classes',
            'manage curriculums',
            'manage classworks',
            'manage exams'
        ]);

        $teacher = Role::findByName('teacher');
        $teacher->givePermissionTo([
            'manage classworks',
            'manage exams'
        ]);

    }
}
