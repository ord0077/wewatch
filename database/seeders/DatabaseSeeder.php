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
            'email' => 'master@wewatch.ae',
            'password' => Hash::make('secret'),
            'role_id' => 1
        ]);

       $this->call([RoleSeeder::class]);

        // \App\Models\User::factory(10)->create();
    }
}
