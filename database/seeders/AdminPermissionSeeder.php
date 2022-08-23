<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Support\Facades\DB;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("admin_permissions")->insert([
          [
            'key' => "USER_MENU",
            "description" => "Permite visualizar o menu de usuários",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "USER_INDEX",
            "description" => "Permite visualizar as listagens de usuários",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "USER_CREATE",
            "description" => "Permite cadastrar um novo usuário",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "USER_EDIT",
            "description" => "Permite atualizar um usuário já cadastrado",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "PERMISSION_MENU",
            "description" => "Permite visualizar o menu de permissões",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "PERMISSION_INDEX",
            "description" => "Permite visualizar as listagens das permissões",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "PERMISSION_CREATE",
            "description" => "Permite cadastrar uma nova permissão",
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            'key' => "PERMISSION_EDIT",
            "description" => "Permite atualizar uma permissão já cadastrada",
            "created_at" => date("Y-m-d H:i:s")
          ],
        ]);
    }
}
