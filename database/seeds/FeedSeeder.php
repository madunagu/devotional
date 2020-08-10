<?php

use Illuminate\Database\Seeder;
use App\Feed;

class FeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inserts = [];
        for($i=0; $i<=10; $i++){
            $inserts[] =[
                'type'=>'audio',
                'item_id' => $i,
                'poster'=>'user',
                'poster_id'=>$i
            ];
            $inserts[] =[
                'type'=>'video',
                'item_id' => $i,
                'poster'=>'user',
                'poster_id'=>$i
            ];
            $inserts[] =[
                'type'=>'event',
                'item_id' => $i,
                'poster'=>'user',
                'poster_id'=>$i
            ];
            $inserts[] =[
                'type'=>'post',
                'item_id' => $i,
                'poster'=>'user',
                'poster_id'=>$i
            ];
        }

        Feed::insert($inserts);
    }
}
