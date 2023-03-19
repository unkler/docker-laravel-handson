<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contract_types')->insert([
            ['name' => '正社員', 'sort_order' => 10],
            ['name' => '契約社員', 'sort_order' => 20],
            ['name' => 'アルバイト', 'sort_order' => 30],
            ['name' => '休職中', 'sort_order' => 40],
            ['name' => '退職', 'sort_order' => 50],
        ]);
    }
}
