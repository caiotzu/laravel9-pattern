<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountySeeder::class,
            AdminRoleSeeder::class,
            AdminPermissionSeeder::class,
            AdminRolePermissionSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
