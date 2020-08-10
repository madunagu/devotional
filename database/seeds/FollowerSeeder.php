<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inserts = [];
        for($i = 0; $i<=10; $i++) {
            $inserts[] = ['user_id' => rand(1, 10), 'follower_id' => 1];
        }
        DB::table('user_followers')->insert($inserts);
    }
}
