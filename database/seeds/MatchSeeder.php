<?php

use Illuminate\Database\Seeder;
use App\Match;
use App\Season;

class MatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $matches = [
            [
                'first_team_id' => 1,
                'second_team_id' => 2,
                'week_number' => 1,
            ],
            [
                'first_team_id' => 3,
                'second_team_id' => 4,
                'week_number' => 1,
            ],
            [
                'first_team_id' => 1,
                'second_team_id' => 3,
                'week_number' => 2,
            ],
            [
                'first_team_id' => 2,
                'second_team_id' => 4,
                'week_number' => 2,
            ],
            [
                'first_team_id' => 2,
                'second_team_id' => 1,
                'week_number' => 3,
            ],
            [
                'first_team_id' => 3,
                'second_team_id' => 4,
                'week_number' => 3,
            ],
            [
                'first_team_id' => 2,
                'second_team_id' => 1,
                'week_number' => 4,
            ],
            [
                'first_team_id' => 3,
                'second_team_id' => 4,
                'week_number' => 4,
            ],
            [
                'first_team_id' => 1,
                'second_team_id' => 3,
                'week_number' => 5,
            ],
            [
                'first_team_id' => 2,
                'second_team_id' => 4,
                'week_number' => 5,
            ],
        ];

        $season = Season::first();
        foreach($matches as $play) {
           Match::create(array_merge($play,
               [
                   'season_id' => $season->id,
                   'is_passed' => Match::MATCH_IS_PASSED,
                   'first_team_goals' => rand(0, 5),
                   'second_team_goals' => rand(0, 5),
               ]
           ));
        }
    }
}
