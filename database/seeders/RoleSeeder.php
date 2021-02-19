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
        $array = array('Super Admin', 'project Admin', 'Blink Manager', 'Wewatch Manager', 'User','Client');
        foreach($array as $arr){
            \DB::table('roles')->insert([
                'role' => $arr
            ]);
        }
        
    }
}
