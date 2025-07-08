<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoCamera;

class TipiCamereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        TipoCamera::create([
            'nome' => 'Espressionismo',
            'descrizione' => 'Un’esplosione emotiva di colori, texture e luce. La Camera Espressionista è pensata per chi cerca un impatto sensoriale immediato: ogni angolo racconta una vibrazione, un’emozione, un urlo pittorico.
            Sulle pareti, quadri originali espressionisti trasmettono tutta la forza interiore dell’arte contemporanea.',        ]);

        TipoCamera::create([
            'nome' => 'Surrealismo',
            'descrizione' => 'Un sogno abitabile dove il reale si dissolve nell’immaginazione. La Camera Surrealista ti accoglie in un ambiente onirico, fatto di forme fluide, specchi distorti e suggestioni impalpabili.
                Le opere esposte ti guidano in un viaggio visivo attraverso l’inconscio e il simbolico.',        ]);

        TipoCamera::create([
            'nome' => 'Cubismo',
            'descrizione' => 'Geometrie decise, prospettive multiple e giochi di riflessi: la Camera Cubista è una celebrazione della struttura e della forma.
            I quadri selezionati mostrano il mondo da nuove angolazioni, frammentandolo in una composizione astratta e affascinante.',
        ]);


       
    }
}
