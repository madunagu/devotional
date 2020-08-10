<?php

use Illuminate\Database\Seeder;

class ChurchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Church::truncate();
        factory(App\Church::class, 10)->create();
    }
}
