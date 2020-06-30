<?php

namespace App\Http\Controllers\SingleApplication;

use App\Http\Controllers\Controller;
use App\Http\Requests\SingleApplication\GetMatchesByParameterRequest;
use App\Services\TeamService;
use Illuminate\Http\JsonResponse;

class MatchController extends Controller
{
    /**
     * Get matches by parameters
     *
     * @param GetMatchesByParameterRequest $request
     * @return JsonResponse
     */
    public function getMatchesByParameters(GetMatchesByParameterRequest $request)
    {
        $season = request()->get('season');
        $week = request()->get('week');

        $teamsInfo = TeamService::getTeamsInfo($season, $week);

        return response($teamsInfo);
    }
}
