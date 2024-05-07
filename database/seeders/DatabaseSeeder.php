<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(IndoRegionSeeder::class);

        $adminRole = Role::where('slug', 'admin')->first();

        User::create([
            'username' => 'lppm',
            'email' => 'lppm@example.com',
            'role_id' => $adminRole->id, // Assigning admin role to the user
            'password' => bcrypt('123456789') // Hashing the password
        ]);
    }
}
