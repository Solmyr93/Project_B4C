<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RateSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('rates')->truncate();
        factory('Laraspace\Rate', 10)->create();
    }

}
