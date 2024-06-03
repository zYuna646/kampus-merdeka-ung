<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Array roles yang akan diisi
        $roles = [
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Guru', 'slug' => 'guru'],
            ['name' => 'Dosen', 'slug' => 'dosen'],
            ['name' => 'Mahasiswa', 'slug' => 'mahasiswa'],

        ];

        // Looping untuk membuat setiap role
        foreach ($roles as $role) {
            // Role::create($role);
        }
        Role::create([
            'name' => 'Operator',
            'slug'=> 'operator',
        ]);
    
    }
}
