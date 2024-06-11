<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User();
        $admin->name = "Admin";
        $admin->email = "admin@sifal.deerwalk.edu.np";
        $admin->password = bcrypt("admin");
        $admin->save();

        $adminRole = Role::where('name', 'admin')->first();
        $admin->roles()->attach($adminRole->id, ['user_id' => $admin->id]);
    }
}
