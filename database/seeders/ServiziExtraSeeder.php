<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServizioExtra;

class ServiziExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        ServizioExtra::create([
            'nome' => 'Servizio Lavanderia',
            'descrizione' => 'Lavaggio, stiratura e piega su richiesta con ritiro e consegna in camera.',
            'prezzo' => 40.00,
            'prezzo_unita' => 'una tantum',
        ]);

        ServizioExtra::create([
            'nome' => 'Autista Privato',
            'descrizione' => 'Trasferimenti eleganti in città con conducente personale.',
            'prezzo' => 100.00,
            'prezzo_unita' => 'giorno',
        ]);

        ServizioExtra::create([
            'nome' => 'Chef Privato in Camera',
            'descrizione' => 'Chef stellato per esperienze gastronomiche riservate, direttamente nella tua suite.',
            'prezzo' => 200.00,
            'prezzo_unita' => 'giorno',
        ]);

        ServizioExtra::create([
            'nome' => 'Colazione in Camera',
            'descrizione' => 'Colazione continentale o internazionale servita con discrezione nella tua camera.',
            'prezzo' => 30.00,
            'prezzo_unita' => 'giorno',
        ]);

        ServizioExtra::create([
            'nome' => 'Accesso Spa & Massaggi',
            'descrizione' => 'Ingresso illimitato alla spa con possibilità di massaggi rilassanti su prenotazione.',
            'prezzo' => 150.00,
            'prezzo_unita' => 'giorno',
        ]);

        ServizioExtra::create([
            'nome' => 'Parrucchiere in Suite',
            'descrizione' => 'Hair stylist professionista disponibile direttamente nella tua camera.',
            'prezzo' => 60.00,
            'prezzo_unita' => 'una tantum',
        ]);

        ServizioExtra::create([
            'nome' => 'Estetista & Trattamenti Viso',
            'descrizione' => 'Trattamenti estetici e skincare personalizzati per il tuo benessere.',
            'prezzo' => 100.00,
            'prezzo_unita' => 'una tantum',
        ]);

    }
}
