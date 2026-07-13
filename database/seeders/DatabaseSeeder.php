<?php

namespace Database\Seeders;

use App\Models\Pessoa;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'cpf' => '00000000000',
            'password' => 'password',
            'ativo' => 1,
            'nivel' => 1
        ]);
        Pessoa::create([
            'cpf' => '00000000000',
            'nome' => 'Taciano Ricardo Maffei Peruzzo',
            'email' => 'tperuzzo@yahoo.com.br',
        ]);
    }
}
