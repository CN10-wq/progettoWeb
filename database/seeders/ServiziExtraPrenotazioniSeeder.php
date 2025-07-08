<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServizioExtraPrenotazione;

class ServiziExtraPrenotazioniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServizioExtraPrenotazione::create([
            'prenotazione_id' => 1,
            'servizio_extra_id' => 1,
            'quantita' => 2,
            'prezzo_unitario' => 40.00,
        ]);

        ServizioExtraPrenotazione::create([
            'prenotazione_id' => 1,
            'servizio_extra_id' => 3,
            'quantita' => 1,
            'prezzo_unitario' => 200.00,
        ]);

        ServizioExtraPrenotazione::create([
            'prenotazione_id' => 2,
            'servizio_extra_id' => 2,
            'quantita' => 5,
            'prezzo_unitario' => 100.00,
        ]);

        ServizioExtraPrenotazione::create([
            'prenotazione_id' => 3,
            'servizio_extra_id' => 1,
            'quantita' => 1,
            'prezzo_unitario' => 40.00,
        ]);
    }
}
