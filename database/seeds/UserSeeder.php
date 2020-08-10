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
        App\User::truncate();
        $user = User::create([
            'name' => 'Ekene Madunagu',
            'email' => 'ekenemadunagu@gmail.com',
            'password' => Hash::make('mercy'),
        ]);

        factory(App\User::class, 50)->create();

    }
}
