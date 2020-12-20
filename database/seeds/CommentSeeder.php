<?php

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Comment::truncate();
        factory(App\Comment::class, 10)->create();
  
    }
}
