<?php

namespace Database\Seeders;

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
        $this->call([
            RolesAndPermissionSeeder::class,
        ]);

        $this->call([
            TipiCamereSeeder::class,
        ]);

        $this->call([
            ServiziExtraSeeder::class,
        ]);

       $this->call([
            CamereSeeder::class,
        ]);

        $this->call([
            StatiSeeder::class,
        ]);

        $this->call([
            ImmaginiCamereSeeder::class,
        ]);

        $this->call([
            PrenotazioniSeeder::class,
        ]);

        $this->call([
            ServiziExtraPrenotazioniSeeder::class,
        ]);
    }
}
