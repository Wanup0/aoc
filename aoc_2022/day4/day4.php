<?php
const INPUT = __DIR__ . "/inputd4.txt";

$epairs = file(INPUT, FILE_IGNORE_NEW_LINES);

$mkpair = fn(string $line) => explode(',', $line);

$pairs = array_map($mkpair, $epairs);
//var_dump($pairs);
$cpt = 0;
$overlap = 0;
foreach ($pairs as $key => $pair) {
    $elf1 = explode('-', $pair[0]);
    $elf2 = explode('-', $pair[1]);
    if($elf1[0] >= $elf2[0] && $elf1[1] <= $elf2[1]) {
        $cpt++;
    } else if($elf2[0] >= $elf1[0] && $elf2[1] <= $elf1[1]) {
        $cpt++;
    } else if( ($elf1[0] >= $elf2[0] && $elf1[0] <= $elf2[1] && $elf1[1] > $elf2[1])
            || ($elf1[1] >= $elf2[0] && $elf1[1] <= $elf2[1] && $elf1[0] < $elf2[0]) ) {
        $overlap++;
    } else if( ($elf2[0] >= $elf1[0] && $elf2[0] <= $elf1[1] && $elf2[1] > $elf1[1])
            || ($elf2[1] >= $elf1[0] && $elf2[1] <= $elf1[1] && $elf2[0] < $elf1[0]) ) {
        $overlap++;
    } else {
        //echo print_r($pair, false), PHP_EOL;
    }
}
echo "R1: ", $cpt, " pair(s) does one range fully contain the other", PHP_EOL;
echo "R2: ", ($overlap+$cpt), " pair(s) do the ranges overlap", PHP_EOL;
?>