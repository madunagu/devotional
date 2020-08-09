<?php

use Illuminate\Database\Seeder;

class VideoPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\VideoPost::class, 100)->create();
    }
}
