<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\UserType;
use Carbon\Carbon;

class UserTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserType::insert([
            [
                'name' => 'cliente',
                'description' => 'Cliente',
                'cpf_required' => true,
                'cnpj_required' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'lojista',
                'description' => 'Lojista',
                'cpf_required' => true,
                'cnpj_required' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
