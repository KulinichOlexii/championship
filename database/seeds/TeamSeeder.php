<?php

use Illuminate\Database\Seeder;
use App\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            'Chelsea',
            'Arsenal',
            'Manchester City',
            'Liverpool',
        ];
        foreach ($teams as $team) {
            Team::create([
                'name' => $team
            ]);
        }
    }
}
