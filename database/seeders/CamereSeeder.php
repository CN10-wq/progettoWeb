<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Camera;

class CamereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        Camera::create([
            'titolo' => 'Appartamento Luci di Città',
            'tipo_id' => 1,
            'prezzo_a_notte' => 400.00,
            'descrizione' => 'Appartamento elegante ispirato a un’opera espressionista dominante, con figure audaci e colori intensi. L’open-space con cucina in marmo e arredi di design crea un ambiente raffinato e immersivo, perfetto per gli amanti dell’arte contemporanea.',
            'capienza' => 8,
        ]);

        Camera::create([
            'titolo' => 'Appartamento Sogno Surrealista',
            'tipo_id' => 2,
            'prezzo_a_notte' => 400.00,
            'descrizione' => 'Un appartamento raffinato e onirico, dominato da un’opera surrealista che trasforma lo spazio in un paesaggio mentale sospeso. La zona living minimal e scultorea, unita alla luce morbida e agli arredi curati, crea un’esperienza abitativa fuori dal tempo, perfetta per chi cerca ispirazione e quiete.',
            'capienza' => 8,
        ]);

        Camera::create([
            'titolo' => 'Appartamento Frammenti Cubisti',
            'tipo_id' => 3,
            'prezzo_a_notte' => 400.00,
            'descrizione' => 'Un appartamento elegante e geometrico, dominato da un’opera cubista che scompone e riassembla la figura umana in piani vibranti. Gli arredi moderni e la luce naturale filtrata dalle ampie finestre completano uno spazio che esprime equilibrio, astrazione e stile contemporaneo.',
            'capienza' => 8,
        ]);

    }
}
