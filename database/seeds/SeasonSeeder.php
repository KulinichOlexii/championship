<?php

use Illuminate\Database\Seeder;
use \App\Season;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Season::create([
           'name' => '2019/20'
       ]);
    }
}
