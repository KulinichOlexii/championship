<?php

namespace App\Services;

use App\Match;
use App\Team;

class TeamService
{
    /**
     * Get team info for season and week
     *
     * @param $seasonId
     * @param $weekNumber
     * @return array
     */
    public static function getTeamsInfo($seasonId, $weekNumber)
    {
        $teams = Team::select(['id', 'name'])->get();
        $matches = Match::where('week_number', '<=', $weekNumber)->where('season_id', $seasonId)->get();

        $teamHistoryInfo = self::getMatchesResults($teams, $matches);
        $thisWeekMatches = Match::getMatchesByWeekOfSeason($seasonId, $weekNumber)->get();
        $predictions = self::getTeamPredictions($teamHistoryInfo);

        return ['team_history_info' => $teamHistoryInfo, 'this_week_matches' => $thisWeekMatches, 'predictions' => $predictions];
    }

    /**
     * Get team predictions for season and week
     *
     * @param $teamHistoryInfo
     * @return mixed
     */
    private static function getTeamPredictions($teamHistoryInfo)
    {
        $maxGoalDiff = $teamHistoryInfo->max('goals_diff');
        $alignment = $teamHistoryInfo->min('goals_diff') * (-1) + $maxGoalDiff * 0.1;
        $countOfTeams = $teamHistoryInfo->count();

        $predictions = $teamHistoryInfo->map(function ($team) use ($alignment, $countOfTeams) {
            return [
                'name' => $team['name'],
                'prediction' => $alignment == 0 ? '-' : '%' . round(($team['goals_diff'] + $alignment) / ($alignment * $countOfTeams) * 100)
            ];
        });

        return $predictions;
    }

    /**
     * Get matches history
     *
     * @param $teams
     * @param $matches
     * @return mixed
     */
    private static function getMatchesResults($teams, $matches)
    {
        return $teams->map(function ($team) use ($matches) {
            $teamMatches = $matches->filter(function ($match) use ($team) {
                  return $match->first_team_id === $team->id || $match->second_team_id === $team->id;
                });
            $goalsFor = $teamMatches->where('first_team_id', $team->id)->sum('first_team_goals') +
                $teamMatches->where('second_team_id', $team->id)->sum('second_team_goals');
            $goalsAgainst = $teamMatches->where('first_team_id', $team->id)->sum('second_team_goals') +
                $teamMatches->where('second_team_id', $team->id)->sum('first_team_goals');
            return [
                'name' => $team->name,
                'played' => $teamMatches->count(),
                'won' => $teamMatches->filter(function ($match) use ($team) {
                        if ($team->id === $match->first_team_id) {
                            return $match->first_team_goals > $match->second_team_goals;
                        } else {
                            return $match->first_team_goals < $match->second_team_goals;
                        }
                    })->count(),
                'drawn' => $teamMatches->filter(function ($match) {
                        return $match->first_team_goals == $match->second_team_goals;
                    })->count(),
                'lose' => $teamMatches->filter(function ($match) use ($team) {
                        if ($team->id === $match->first_team_id) {
                            return $match->first_team_goals < $match->second_team_goals;
                        } else {
                            return $match->first_team_goals > $match->second_team_goals;
                        }
                    })->count(),
                'goals_for' => $goalsFor,
                'goals_against' => $goalsAgainst,
                'goals_diff' => $goalsFor - $goalsAgainst
            ];
        });
    }
}
