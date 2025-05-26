<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!User::where('email', 'jessica@martins.com')->first()){
            User::create([
                'name' => 'Jesisca',
                'email' => 'jessica@martins.com',
                'password' => Hash::make('123456a', ['rounds' => 12]),
            ]);
        }
        if(!User::where('email', 'pedro@martins.com')->first()){
            User::create([
                'name' => 'pedro',
                'email' => 'pedro@martins.com',
                'password' => Hash::make('123456a', ['rounds' => 12]),
            ]);
        }
        if(!User::where('email', 'victor@martins.com')->first()){
            User::create([
                'name' => 'victor',
                'email' => 'victor@martins.com',
                'password' => Hash::make('123456a', ['rounds' => 12]),
            ]);
        }
    }
}
