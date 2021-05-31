<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\UserRole;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call( UserSeeder::class);

        $this->call( RoleSeeder::class);

        $this->call( PostSeeder::class);

    }
}
