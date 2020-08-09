<?php

use Illuminate\Database\Seeder;

class AudioPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\AudioPost::class, 100)->create();
    }
}
