<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 10; $i++) {
            DB::table('customers')->insert(
                ['nama' => Str::random(10), 'alamat' => Str::random(25), 'tipe_member' => rand(1,3)]
            );
        };
    }
}
