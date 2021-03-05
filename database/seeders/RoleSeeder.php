<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            ['role' => 'Super Admin'], 
            ['role' => 'project Admin'], 
            ['role' => 'Blink Manager'], 
            ['role' => 'Wewatch Manager'],
            ['role' =>  'User'],
            ['role' => 'Client'],
            ['role' => 'Security Guard']
        ]);
    }
}
