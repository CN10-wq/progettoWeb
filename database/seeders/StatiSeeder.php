<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stato;

class StatiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stato::create(['nome' => 'Annullata']);

        Stato::create(['nome' => 'Confermata']);

        Stato::create(['nome' => 'In attesa di conferma']);

        Stato::create(['nome' => 'Effettuata']);
    }
}
