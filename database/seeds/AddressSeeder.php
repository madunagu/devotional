<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Address;
use App\Universal\Constants;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::truncate();
        factory(Address::class, 30)->create();
        $query = [];

        for ($i = 0; $i < 10; $i++) {
            $query[] =
                [
                    'address_id' => $i,
                    'addressable_id' => 10 - $i,
                    'addressable_type' => Constants::$_[$i % count(Constants::$_)],
                ];
        }
        DB::table('addressables')->insert($query);
    }
}
