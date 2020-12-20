<?php

use Illuminate\Database\Seeder;
use App\Universal\Constants;
use Illuminate\Support\Facades\DB;

class ChurchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Church::truncate();
        factory(App\Church::class, 10)->create();

        for ($i = 0; $i < 10; $i++) {
            $query[] =
                [
                    'church_id' => $i,
                    'churchable_id' => 10 - $i,
                    'churchable_type' => Constants::$_[$i % count(Constants::$_)],
                ];
        }
        DB::table('churchables')->insert($query);
    }
}
