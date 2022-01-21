<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTypeTableSeeder::class);

        User::factory()->count(10)->create();

        $this->call(FinancialAccountSeeder::class);
    }
}
