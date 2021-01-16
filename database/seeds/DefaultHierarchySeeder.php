<?php

use Illuminate\Database\Seeder;
use App\DefaultHierarchy;

class DefaultHierarchySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DefaultHierarchy::truncate();
        $heirarchies = [[
            'hierarchy_group_id'=>'1',
            'rank' => '1',
            'position_name'=>'General Overseer',
            'position_slang'=>'GO'
        ],[
            'hierarchy_group_id'=>'1',
            'rank' => '2',
            'position_name'=>'Assistant Overseer',
            'position_slang'=>'AO'
        ],[
            'hierarchy_group_id'=>'1',
            'rank' => '3',
            'position_name'=>'Praise Leader',
            'position_slang'=>'Lead Singer'
        ],
        [
            'hierarchy_group_id'=>'1',
            'rank' => '3',
            'position_name'=>'Prayer Leader',
            'position_slang'=>'Prayoo'
        ]
    
    
    ];
        DefaultHierarchy::insert($heirarchies);
    }
}
