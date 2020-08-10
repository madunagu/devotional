<?php

use Illuminate\Database\Seeder;
use App\VideoPost;

class VideoPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VideoPost::truncate();
        factory(App\VideoPost::class, 100)->create();
    }
}
