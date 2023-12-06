<?php

$input = "./day2/inputd2.txt";

$games = explode("\n", file_get_contents($input));
// Opponent: A -> Rock, B -> Paper, C -> Scissors
// Me:       X -> Rock, Y -> Paper, Z -> Scissors
$fn = function(string $game) {
    
    $val = $game[2] === 'X' ? 1 : ($game[2] === 'Y' ? 2 : 3);
    if(ord($game[0]) === 65) { // Opponent plays Rock
        $val += ord($game[2]) === 90 ? 0 // Rock defeats Scissors => loose
        : (ord($game[2]) === 88 ? 3 // Rock & Rock => draw
        : 6) ; // Win
    } else if(ord($game[0]) === 66) { // Paper
        $val += ord($game[2]) === 88 ? 0 // Paper defeats Rocks => loose
        : (ord($game[2]) === 89 ? 3 // Paper & Paper => draw
        : 6) ; // Win
    } else { // Scissors
        $val += ord($game[2]) === 89 ? 0 // Scissors defeats Paper => loose
        : (ord($game[2]) === 90 ? 3 // Scissors & Scissors => draw
        : 6) ; // Win
    }
    //echo $game[0], " vs ", $game[2], " => ", $val, PHP_EOL;
    return $val;
};
//echo ord('A'), ord('B'), ord('C'), PHP_EOL;
//echo ord('X'), ord('Y'), ord('Z'), PHP_EOL;
// Opponent: A -> Rock, B -> Paper, C -> Scissors
// Me:       X -> LOOSE, Y -> DRAW, Z -> WIN
// Me:       X -> Rock, Y -> Paper, Z -> Scissors
$fn2 = function(string $game) {
    //echo $game[0], " vs ", $game[2], PHP_EOL;
    if(ord($game[0]) === 65) { // Opponent plays Rock
        $game[2] = $game[2] === 'X' ? 'Z' : ($game[2] === 'Y' ? 'X' : 'Y');
    } else if(ord($game[0]) === 66) { // Paper
        $game[2] = $game[2] === 'X' ? 'X' : ($game[2] === 'Y' ? 'Y' : 'Z');
    } else { // Scissors
        $game[2] = $game[2] === 'X' ? 'Y' : ($game[2] === 'Y' ? 'Z' : 'X');
    }
    //echo $game[0], " vs ", $game[2], PHP_EOL;
    return $game;
};
echo "R1 The Total score is ", array_sum(array_map($fn, $games)), PHP_EOL;

$ngames = array_map($fn2, $games);
echo "R2 The Total score is ", array_sum(array_map($fn, $ngames)), PHP_EOL;
?>