<?php
const INPUT = __DIR__ . "/inputd5.txt";

$parts = explode("\n\n", file_get_contents(INPUT));

// stacks
$fill = fn($elt) => [];
$stacks = [[],[],[],[],[],[],[],[],[],[]];
$allLines = explode("\n", $parts[0]);
for($l = count($allLines) - 2; $l >= 0; $l--) {
    $j = 1;
    for($i = 1; $i < strlen($allLines[$l]); $i+=4) {
        if( isset($allLines[$l][$i]) && $allLines[$l][$i] !== ' ')
            array_push($stacks[$j], $allLines[$l][$i]);
        $j++;
    }
}
// copy array
$stacks9001 = $stacks;

// instructions R1
$instructions = explode("\n", $parts[1]);
foreach ($instructions as $key => $instruction) {
    list($m, $nb, $f, $from, $t, $to) = explode(" ", $instruction); // e.g.: move 1 from 2 to 1
    for($n = 1; $n <= $nb; $n++) {
        $elt = array_pop($stacks[$from]);
        array_push($stacks[$to], $elt);
    }
}
echo "Round 1: ";
for($i = 1 ; $i < count($stacks); $i++) {
    $elt = end($stacks[$i]);
    if(isset($elt) || $elt !== FALSE)
        echo $elt;
}
echo PHP_EOL;

// instructions R2
$instructions = explode("\n", $parts[1]);
foreach ($instructions as $key => $instruction) {
    list($m, $nb, $f, $from, $t, $to) = explode(" ", $instruction); // e.g.: move 1 from 2 to 1
    $elts = [];
    for($n = 1; $n <= $nb; $n++) {
        array_push($elts, array_pop($stacks9001[$from]));
    }
    //echo implode(",", $elts), PHP_EOL;
    while (count($elts) > 0) {
        array_push($stacks9001[$to], array_pop($elts));
    }
}
echo "Round 2: ";
for($i = 1 ; $i < count($stacks9001); $i++) {
    $elt = end($stacks9001[$i]);
    if(isset($elt) || $elt !== FALSE)
        echo $elt;
}
echo PHP_EOL;

?>