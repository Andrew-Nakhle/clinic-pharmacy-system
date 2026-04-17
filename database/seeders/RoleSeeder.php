<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TraitUseAdaptation\Precedence;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Role::create(['name' => 'doctor', 'guard_name' => 'web']);
        Role::create(['name' => 'patient', 'guard_name' => 'web']);
        Role::create(['name' => 'secretary', 'guard_name' => 'web']);
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
         $adminpremmission=Permission::create(['name' => 'add_DoctorORSecretary', 'guard_name' => 'web']);
         $admin = Role::findByName('admin');
         $admin->givePermissionTo($adminpremmission);
        $admin = User::create([
            'first_name' => 'Super',
            'last_name'  => 'Admin',
            'phone'      => '0912345678',
            'email'      => 'admin@clinic.com',
            'password'   => Hash::make('password123'),
            'gender'     => 'male',
            'role'       => 'admin',
        ]);
        $admin->assignRole('admin');


    }
}
