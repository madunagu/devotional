<?php

use Illuminate\Database\Seeder;

class ProfileMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\ProfileMedia::truncate();
        factory(App\ProfileMedia::class, 10)->create();
    }
}
