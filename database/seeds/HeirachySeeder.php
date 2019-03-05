<?php

use Illuminate\Database\Seeder;
use App\Heirachy;

class HeirachySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Heirachy::truncate();
        $heirachies = [[
          'heirachy_group_id'=>'1',
          'rank' => '1',
          'position_name'=>'General Overseer',
          'person_name'=>' John David',
          'position_slang'=>'GO'
        ],[
          'heirachy_group_id'=>'1',
          'rank' => '2',
          'position_name'=>'Assistant Overseer',
          'person_name'=>'Owen Kings',
          'position_slang'=>'AO'
        ],[
          'heirachy_group_id'=>'1',
          'rank' => '3',
          'position_name'=>'Praise Leader',
          'person_name'=>' Michael Jordan',
          'position_slang'=>'Lead Singer'
        ]];
            Heirachy::insert($heirachies);

    }
}
