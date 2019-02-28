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
        $heirachies = [[
          'heirachy_group_id'=>'1',
          'rank' => '1',
          'position_name'=>'General Overseer',
          'position_slang'=>'GO'
        ],[
          'heirachy_group_id'=>'1',
          'rank' => '2',
          'position_name'=>'Assistant Overseer',
          'position_slang'=>'AO'
        ],[
          'heirachy_group_id'=>'1',
          'rank' => '3',
          'position_name'=>'Praise Leader',
          'position_slang'=>'Lead Singer'
        ]];
            Heirachy::insert($heirachies);

    }
}
