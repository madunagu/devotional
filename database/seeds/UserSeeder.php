<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'name' => 'Ekene Madunagu',
            'email' => 'ekenemadunagu@gmail.com',
            'password' => Hash::make('mercy'),
        ]);
    }
}
