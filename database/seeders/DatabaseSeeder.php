<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            ['identification' => '0000','name' => 'Administrador','password' => bcrypt('0000'),'role' => 'super_admin', 'created_at' => date("Y-m-d H:i:s")],
            ['identification' => '1234','name' => 'Administrador','password' => bcrypt('1234'),'role' => 'admin', 'created_at' => date("Y-m-d H:i:s")]
        ]);

        DB::table('entities')->insert([
            ['id_user' => 1,'name' => 'Clinica','description' => 'Clinica dental','phone' => null, 'created_at' => date("Y-m-d H:i:s")],
            ['id_user' => 2,'name' => 'Lic. Chacon','description' => 'Bufet de abogados','phone' => null, 'created_at' => date("Y-m-d H:i:s")],
        ]);

        DB::table('services')->insert([
            ['id_entity' => 1,'name' => 'Test','description' => 'Test description','price' => 6700, 'created_at' => date("Y-m-d H:i:s")],
            ['id_entity' => 1,'name' => 'Test 1','description' => 'Test description 1','price' => 4500, 'created_at' => date("Y-m-d H:i:s")]
        ]);

        Storage::makeDirectory('public/entities');

    }
}
