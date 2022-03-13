<?php

function calculate($fileName): int
{
    $input = fopen($fileName, 'r');
    $number_bets = fgets($input);
    $balance = 0;
    $bets = array();
    for ($i = 0; $i < $number_bets; $i++) {
        list($bets_id_game, $bets_sum, $bets_result) = explode(" ", fgets($input));
        $bets_result = trim($bets_result);
        $bets[$bets_id_game][$bets_result]=$bets_sum;
        $balance -=$bets_sum;
    }
    $number_game = fgets($input);
    for ($i = 0; $i < $number_game; $i++) {
        list($game_id, $game_coeff_left, $game_coeff_right, $game_coeff_draw, $game_result) = explode(" ", fgets($input));
        $game_result = trim($game_result);
        if (isset($bets[$game_id][$game_result])) {
            $winning = $bets[$game_id][$game_result];
            switch ($game_result) {
                case 'L':
                    $winning *= $game_coeff_left;
                    break;
                case 'R':
                    $winning *= $game_coeff_right;
                    break;
                case 'D':
                    $winning *= $game_coeff_draw;
                    break;
            }
            $balance += $winning;
        }
    }
    return $balance;
}
function task_A($inputData, $inputAns)
{
    echo "Результаты тестов: <br><br>";
    for ($i = 0; $i < sizeof($inputData); $i++) {
        $output = fopen($inputAns[$i], 'r');
        $answer = fgets($output);
        $result = calculate($inputData[$i]);
        echo($i + 1) . '. ';
        if ($answer == $result) {
            echo 'ОК<br>';
        } else {
            echo 'Error<br>';
        }
        echo('Your answer: ' . $result . '<br>Correct answer: ' . $answer . '<br><br>');
    }
}

task_A(glob('A/*.dat'), glob('A/*.ans'));