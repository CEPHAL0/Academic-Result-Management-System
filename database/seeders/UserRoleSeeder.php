<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the number of users and roles you want to seed
        $numberOfUsers = 3;
        $numberOfRoles = 4;

        // Seed users
        User::factory($numberOfUsers)->create()->each(function ($user) use ($numberOfRoles) {
            // Attach random roles to each user
            $roles = Role::inRandomOrder()->limit(rand(1, $numberOfRoles))->get();
            $user->roles()->attach($roles->pluck('id')->toArray());
        });
    }
}
