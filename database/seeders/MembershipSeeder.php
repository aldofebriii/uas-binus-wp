<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('membership')->insert([
            ['nama' => 'pemula', 'diskon' => 0.05, 'min_profit' => 60_000_000],
            ['nama' => 'menengah', 'diskon' => 0.15, 'min_profit' => 250_000_000],
            ['nama' => 'sepuh', 'diskon' => 0.20, 'min_profit' => 500_000_000]
        ]);
    }
}
