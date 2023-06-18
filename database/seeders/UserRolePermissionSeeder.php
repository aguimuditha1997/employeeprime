<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_user_value = [
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];

        DB::beginTransaction();

        try{
            $staff = User::create(array_merge([
                'email'=>'staff@gmail.com',
                'name'=>'staff',

            ],$default_user_value));

            $hrd = User::create(array_merge([
                'email'=>'hrd@gmail.com',
                'name'=>'hrd',

            ],$default_user_value));

            $admin = User::create(array_merge([
                'email'=>'admin@gmail.com',
                'name'=>'admin',

            ],$default_user_value));

            $role_staff = Role::create(['name'=>'staff']);
            $role_hrd = Role::create(['name'=>'hrd']);
            $role_admin = Role::create(['name'=>'admin']);


            $permission = Permission::create(['name'=>'read role']);
            $permission = Permission::create(['name'=>'create role']);
            $permission = Permission::create(['name'=>'update role']);
            $permission = Permission::create(['name'=>'delete role']);
            Permission::create((['name'=> 'read konfigurasi']));

            $role_admin->givePermissionTo('read role');
            $role_admin->givePermissionTo('create role');
            $role_admin->givePermissionTo('update role');
            $role_admin->givePermissionTo('delete role','read konfigurasi');

            $staff->assignRole('staff');
            $hrd->assignRole('hrd');
            $admin->assignRole('admin');


            DB::commit();

        }catch(\Throwable $th){
            DB::rollBack();
        }


    }
}
