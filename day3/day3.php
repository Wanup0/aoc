<?php
const INPUT = __DIR__ . "/inputd3.txt";

$getPriority = fn(string $char) => ( ord($char) > 96 ? ord($char) - ord('a') + 1 : ord($char) - ord('A') + 27 );

$backpacks = file(INPUT, FILE_IGNORE_NEW_LINES);
//var_dump($backpacks);

$sum = 0;
foreach($backpacks as $k => $bag) {
    // detects item in both compartments
    $len = strlen($bag);
    $size_container = $len / 2;
    $i = 0;  // start index of the first container
    $j = $size_container; // start index of the second container
    $found = false;
    while(!$found && $i < $size_container) {
        $j = $size_container;
        while(!$found && $j < $len) {
            if($bag[$i] === $bag[$j]) {
                $found = true;
            } else {
                $j++;
            }
        }
        $i++;
    }
    //echo "Found at ", $k, " => '", $bag[$j] ,"'", " with a priority value of ", $getPriority($bag[$j]) , PHP_EOL;
    $sum += $getPriority($bag[$j]) ;
}
echo "R1: Sum of priorities : ", $sum, PHP_EOL;

$sum = 0;
for($b = 0; $b < count($backpacks) - 2; $b += 3) {
    $i = 0;
    $found = false;
    while(!$found && $i < strlen($backpacks[$b])) {
        $j = 0;
        while(!$found && $j < strlen($backpacks[$b+1])) {
            $k = 0;
            while(!$found && $k < strlen($backpacks[$b+2])) {
                if($backpacks[$b][$i] === $backpacks[$b+1][$j] 
                && $backpacks[$b][$i] === $backpacks[$b+2][$k]) {
                    $found = true;
                    $sum += $getPriority($backpacks[$b][$i]);
                } else {
                    $k++;
                }
            }
            $j++;
        }
        $i++;
    }
}
echo "R1: Sum of priorities : ", $sum, PHP_EOL;

?>