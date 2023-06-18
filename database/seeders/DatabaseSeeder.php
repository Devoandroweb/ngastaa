<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@mail.com',
        //     'password' => Hash::make('admin'),
        // ]);
        $user = \App\Models\User::create([
            'name' => 'owner',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('owner'),
            'owner' => 1
        ]);
        $user->assignRole('owner');

        $user = \App\Models\User::create([
            'name' => 'SUPER ADMIN',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('admin'),
            'owner' => 1
        ]);
        $user->assignRole('admin');
    }
}
