<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchIndexRequest;
use App\Match;
use App\Season;
use App\Services\TeamService;
use Illuminate\Http\Response;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param MatchIndexRequest $request
     * @return Response
     */
    public function index(MatchIndexRequest $request)
    {
        $seasonId = request()->get('season');
        $weekNumber = request()->get('week');

        if (!$seasonId) {
            $seasonId = Match::where('is_passed', Match::MATCH_IS_PASSED)
            ->max('season_id');
        }

        $lastWeekNumber = Match::where('is_passed', Match::MATCH_IS_PASSED)
            ->where('season_id', $seasonId)
            ->max('week_number');
        if (!$weekNumber) {
            $weekNumber = $lastWeekNumber;
        }

        $data = TeamService::getTeamsInfo($seasonId, $weekNumber);
        $data = array_merge($data, [
                'seasons' => Season::all(),
                'current_week' => $weekNumber,
                'last_week' => $lastWeekNumber
            ]);

        return view('index', compact('data', $data));
    }
}
