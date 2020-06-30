<template>
    <div id="container">
        <div class="flex p-6 items-center">
            <table class="inline-block bg-gray-100 p-3">
                <caption><b>League table</b></caption>
                <tr>
                    <th>Name</th>
                    <th class="w-10">P</th>
                    <th class="w-10">W</th>
                    <th class="w-10">D</th>
                    <th class="w-10">L</th>
                    <th class="w-10">GF</th>
                    <th class="w-10">GA</th>
                    <th class="w-10">GD</th>
                </tr>
                <tr v-for="team in leagueTeamsData">
                    <td
                        v-for="field in team"
                        class="text-center"
                    >
                     {{ field}}
                    </td>
                </tr>
            </table>
            <table class="inline-block ml-8 bg-gray-100 p-3">
                <caption class="whitespace-no-wrap">
                    <b>Match results {{ currentWeek }}<sup>th</sup>week Match Result</b>
                </caption>
                <tr v-if="!weekMatchesResults.length">
                    <td class="text-center">-</td>
                </tr>
                <tr v-for="match in weekMatchesResults">
                    <td class="text-left"> {{ match.first_team.name }}</td>
                    <td class="text-center">{{ match.first_team_goals }}:{{ match.second_team_goals }}</td>
                    <td class="text-right"> {{ match.second_team.name }}</td>
                </tr>
            </table>
            <table class="inline-block ml-8 bg-gray-100 p-3">
                <caption>
                    <b>Predictions</b>
                </caption>
                <tr v-for="team in predictionTeams">
                    <td>{{ team.name }}</td>
                    <td>{{ team.prediction }}</td>
                </tr>
            </table>
        </div>
        <div class="p-6">
            <select
                class="mx-8"
                v-model="currentSeason"
                @change="seasonChanged()"
            >
                <option
                    v-for="season in seasons"
                    :value="season"
                >
                    {{ season.name }}
                </option>
            </select>
            <button
                class="btn btn-blue mx-8"
                @click="navigate(false)"
                :disabled="currentWeek <= 1"
            >
                Prev week
            </button>
            Week: {{ currentWeek }}
            <button
                class="btn btn-blue mx-8"
                @click="navigate(true)"
                :disabled="currentWeek >= maxWeek"
            >
                Next week
            </button>
        </div>
    </div>
</template>
<script>
    export default {
        name: "championship",
        data: function() {
            return {
                maxWeek: 0,
                seasons: null,
                currentSeason: null,
                currentWeek: 0,
                leagueTeamsData: null,
                weekMatchesResults: null,
                predictionTeams: null
            }},
        props: ['matchesData', 'routeGetMatchesByParameter'],
        created() {
            this.leagueTeamsData = this.matchesData.team_history_info
            this.weekMatchesResults = this.matchesData.this_week_matches
            this.seasons = this.matchesData.seasons
            this.predictionTeams = this.matchesData.predictions
            this.currentSeason = this.seasons[this.seasons.length - 1]
            this.currentWeek = this.matchesData.current_week
            this.maxWeek = this.matchesData.last_week
        },
        methods: {
            navigate(addWeek) {
                if (addWeek) {
                    if (this.currentWeek < this.maxWeek) {
                        this.currentWeek++
                    }
                } else {
                    if (this.currentWeek > 1) {
                        this.currentWeek--
                    }
                }
              this.serverRequest()
            },
            seasonChanged(){
                this.serverRequest()
            },
            serverRequest() {
                axios.get(this.routeGetMatchesByParameter  + '?season=' + this.currentSeason.id + '&week=' + this.currentWeek)
                    .then((response) => {
                        this.leagueTeamsData = response.data.team_history_info
                        this.weekMatchesResults = response.data.this_week_matches
                        this.predictionTeams = response.data.predictions
                    })
            }
        }
    }
</script>
