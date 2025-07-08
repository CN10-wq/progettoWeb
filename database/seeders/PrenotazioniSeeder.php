<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prenotazione;

class PrenotazioniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prenotazione::create([
            'user_id' => 3,
            'camera_id' => 1, 
            'stato_id' => 3, 
            'data_inizio' => '2025-07-20',
            'data_fine' => '2025-07-25',
            'eventuali_richieste_cliente' => 'Vorrei avere una camera ai piani alti, se possibile.',
            'prezzo_totale_camera' => 11000.00,
            'numero_persone' => 4,
        ]);

        Prenotazione::create([
            'user_id' => 3,
            'camera_id' => 2,
            'stato_id' => 2, 
            'data_inizio' => '2025-08-20',
            'data_fine' => '2025-08-23',
            'eventuali_richieste_cliente' => 'Richiedo la colazione in camera.',
            'prezzo_totale_camera' => 10500.00,
            'numero_persone' => 2,
        ]);

        Prenotazione::create([
            'user_id' => 3,
            'camera_id' => 3,
            'stato_id' => 1, 
            'data_inizio' => '2025-07-25',
            'data_fine' => '2025-07-26',
            'eventuali_richieste_cliente' => null,
            'prezzo_totale_camera' => 1800.00,
            'numero_persone' => 1,
        ]);
    }
}
