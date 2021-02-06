<?php

use Illuminate\Database\Seeder;

class DevotionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Devotional::truncate();
        factory(App\Devotional::class, 100)->create();

    }
}
