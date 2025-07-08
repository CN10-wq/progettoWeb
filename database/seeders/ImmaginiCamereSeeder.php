<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ImmagineCamera;

class ImmaginiCamereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ImmagineCamera::create([
            'camera_id' => 1,
            'path' => 'aa1.jpg',
        ]);

        ImmagineCamera::create([
            'camera_id' => 1,
            'path' => 'aa2.jpg',
        ]);

        ImmagineCamera::create([
            'camera_id' => 1,
            'path' => 'aa3.jpg',
        ]);

        ImmagineCamera::create([
            'camera_id' => 1,
            'path' => 'aa4.jpg',
        ]);

        ImmagineCamera::create([
            'camera_id' => 1,
            'path' => 'aa5.jpg',
        ]);

        ImmagineCamera::create([
            'camera_id' => 2,
            'path' => 'app1.jpg',
        ]);

        ImmagineCamera::create([
            'camera_id' => 2,
            'path' => 'app2.jpg',
        ]);

        ImmagineCamera::create([
            'camera_id' => 2,
            'path' => 'app3.jpg',
        ]);

        ImmagineCamera::create([
            'camera_id' => 2,
            'path' => 'app4.jpg',
        ]);

        ImmagineCamera::create([
            'camera_id' => 2,
            'path' => 'app5.jpg',
        ]);

        ImmagineCamera::create([
            'camera_id' => 3,
            'path' => 'appar1.jpg',
        ]);

        ImmagineCamera::create([
            'camera_id' => 3,
            'path' => 'appar2.jpg',
        ]);

        ImmagineCamera::create([
            'camera_id' => 3,
            'path' => 'appar3.jpg',
        ]);

        ImmagineCamera::create([
            'camera_id' => 3,
            'path' => 'appar4.jpg',
        ]);

        ImmagineCamera::create([
            'camera_id' => 3,
            'path' => 'appar5.jpg',
        ]);
    }
}
