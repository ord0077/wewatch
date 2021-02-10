<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('secret'),
            'role_id' => 1
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
