<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Client;
use App\Models\Workplace;

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
            ContractTypeSeeder::class,
            RegionsSeeder::class,
            PrefecturesSeeder::class,
        ]);

        Employee::factory(100)->create();
        Client::factory(30)->create();
        Workplace::factory(50)->create();
    }
}
