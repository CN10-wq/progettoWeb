<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class RolesAndPermissionSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        $admin1 = User::create([
            'name' => 'Admin',
            'surname' => '1',
            'email' => 'admin1@hotelmuseum.com',
            'password' => Hash::make('password1'),
        ]);
        $admin1->assignRole('admin');

        $admin2 = User::create([
            'name' => 'Admin',
            'surname' => '2',
            'email' => 'admin2@hotelmuseum.com',
            'password' => Hash::make('password2'),
        ]);
        $admin2->assignRole('admin');

        $cliente = User::create([
            'name' => 'Cliente',
            'surname' => 'Test',
            'email' => 'cliente@example.com',
            'password' => Hash::make('12345678'),
        ]);
        $cliente->assignRole('user');
    }
}
