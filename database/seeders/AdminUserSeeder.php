<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = DB::table('admin_roles')->where('description', 'Administrador')->first();

        DB::table("admin_users")->insert([
            "role_id" => $role->id,
            "name"  => "Caio Costa",
            "email" => "caio@tdex.com.br",
            "password" => bcrypt("Tdex@dev1"),
            "created_at" => date("Y-m-d H:i:s")
        ]);
    }
}
