<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'user'],
            ['name' => 'subAdmin']
        ]);

        DB::table('role_user')->insert([
            'role_id' => '1',
            'user_id' => '1'
        ]);
//        for($i = 2; $i < 12; $i++) {
//            DB::table('role_user')->insert([
//                'role_id' => '2',
//                'user_id' => $i
//            ]);
//        }
    }
}
