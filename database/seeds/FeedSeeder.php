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

        Feed::truncate();
        $events = App\Event::find(1);
        $audio = App\AudioPost::find(1);
        $video = App\VideoPost::find(1);
        $posts = App\Post::find(1);
        $inserts = [];
        for($i=1; $i<=10; $i++){
            $inserts[] =[
                'type'=>'audio',
                'item_id' => $i,
                'poster'=>'user',
                'poster_id'=>$i,
                'src_url'=>$audio->src_url,
                'name'=>$audio->name,
                'profile_media_id'=> $audio->profile_media_id
            ];
            $inserts[] =[
                'type'=>'video',
                'item_id' => $i,
                'poster'=>'user',
                'poster_id'=>$i,
                'src_url'=>$video->src_url,
                'name'=>$video->name,
                'profile_media_id'=> $video->profile_media_id
            ];
            $inserts[] =[
                'type'=>'event',
                'item_id' => $i,
                'poster'=>'user',
                'poster_id'=>$i,
                'name' => $events->name,
                'profile_media_id' => $events->profile_media_id,
                'src_url' => null

            ];
            $inserts[] =[
                'type'=>'post',
                'item_id' => $i,
                'poster'=>'user',
                'poster_id'=>$i,
                'profile_media_id' => $posts->profile_media_id,
                'name' => $posts->name,
                'src_url' => null
            ];
        }

        Feed::insert($inserts);
    }
}
