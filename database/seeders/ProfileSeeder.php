<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("profiles")->insert([
          [
            "description" => 'REVENDA',
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            "description" => 'ITE',
            "created_at" => date("Y-m-d H:i:s")
          ],
          [
            "description" => 'MONTADORA',
            "created_at" => date("Y-m-d H:i:s")
          ],
        ]);
    }
}
