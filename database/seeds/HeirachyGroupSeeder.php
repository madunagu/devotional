<?php

use Illuminate\Database\Seeder;
use App\HeirachyGroup;

class HeirachyGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HeirachyGroup::create(['id'=>1,
          'name'=>'default group',
          'description'=>'default heirachy group for small churches',
          'user_id' => '1',
        ]);
    }
}
