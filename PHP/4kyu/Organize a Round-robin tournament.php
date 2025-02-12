<?php
/*
You are organizing a soccer tournament, so you need to build a matches table.

The tournament is composed by 20 teams. It is a round-robin tournament (all-play-all), so it has 19 rounds, and each team plays once per round. Each team confront the others once in the tournament (each match does not repeat in the tournament).

Each line of the matrix represents one round. Each column of the matrix represents one match. The match is represented as an array/tuple with two teams. Each team is represented as a number, starting from 1 until the number of teams.

Example:

buildMatchesTable(4)

// Should return a matrix like that:
[
  [[1,2], [3, 4]],  // first round:  1 vs 2, 3 vs 4
  [[1,3], [2, 4]],  // second round: 1 vs 3, 2 vs 4
  [[1,4], [2, 3]]   // third round:  1 vs 4, 2 vs 3
]

You should not care about the order of the teams in the match, nor the order of the matches in the round. You should just care about the rules of the tournament.

Good luck!
*/
function buildMatchesTable(int $numberOfTeams): array {
    $n = $numberOfTeams + ($numberOfTeams % 2);
    $rounds = [];
    
    $teams = range(1, $n);
    
    for($round = 0; $round < $n - 1; $round++) {
        $matches = [];
        
        for($i = 0; $i < $n / 2; $i++) {
            $team1 = $teams[$i];
            $team2 = $teams[$n - 1 - $i];
            
            if($team1 <= $numberOfTeams && $team2 <= $numberOfTeams) {
                $matches[] = [$team1, $team2];
            }
        }
        
        $firstTeam = $teams[0];
        $lastTeam = array_pop($teams);
        array_splice($teams, 1, 0, [$lastTeam]);
        array_push($teams, $teams[count($teams) - 1]);
        array_pop($teams);
        
        $rounds[] = $matches;
    }
    
    return $rounds;
}
?>