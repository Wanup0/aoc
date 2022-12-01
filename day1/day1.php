<?php

$input = "./day1/inputd1.txt";

$elves = explode("\n\n", file_get_contents($input));

$fn1 = fn($value) => explode("\n", $value);
$fn2 = fn($value) => array_sum($value);
$elves_items = array_map($fn1, $elves);
$elves_items_max = array_map($fn2, $elves_items);
sort($elves_items_max);
//var_export($elves_items_max);

$cnt = count($elves_items_max);
echo "Most calories ".$elves_items_max[$cnt-1];

// part 2
// top 3

echo "\nSum of top 3 elves calories ".($elves_items_max[$cnt-1] + $elves_items_max[$cnt-2] + $elves_items_max[$cnt-3])
    ."\n";
?>