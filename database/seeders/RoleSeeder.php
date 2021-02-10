<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array('Super Admin', 'Admin', 'Blink Manager', 'Wewatch Manager', 'User');
        foreach($array as $arr){
            \DB::table('roles')->insert([
                'role' => $arr
            ]);
        }
        
    }
}
