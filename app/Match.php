<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    const MATCH_IS_PASSED = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function firstTeam()
    {
        return $this->belongsTo(Team::class, 'first_team_id');
    }

    public function secondTeam()
    {
        return $this->belongsTo(Team::class, 'second_team_id');
    }

    public function scopeGetMatchesByWeekOfSeason($query, $seasonId, $weekNumber)
    {
        return $query->where('week_number', $weekNumber)->where('season_id', $seasonId)
                ->with(['firstTeam', 'secondTeam']);
    }
}
