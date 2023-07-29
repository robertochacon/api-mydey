<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            ['identification' => '1234','name' => 'Administrador','password' => bcrypt('1234'),'role' => 'admin', 'created_at' => date("Y-m-d H:i:s")],
        ]);

        DB::table('services')->insert([
            ['name' => 'Test','description' => 'Test description','price' => 6700, 'created_at' => date("Y-m-d H:i:s")],
            ['name' => 'Test 1','description' => 'Test description 1','price' => 4500, 'created_at' => date("Y-m-d H:i:s")]
        ]);

        DB::table('entities')->insert([
            ['name' => 'Hormigones Bonao','description' => 'Bonao','phone' => null, 'created_at' => date("Y-m-d H:i:s")],
            ['name' => 'Quisquella','description' => 'Santo Domingo','phone' => null, 'created_at' => date("Y-m-d H:i:s")],
        ]);

    }
}
