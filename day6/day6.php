<?php
const INPUT = __DIR__ . "/inputd6.txt";

$streams = file(INPUT, FILE_IGNORE_NEW_LINES);

//var_dump($streams);
const MARKER_SIZE = 14;

foreach($streams as $stream) {

    $found = false;
    $reads = MARKER_SIZE;
    $buff = substr($stream, 0, -(strlen($stream)-MARKER_SIZE));

    // echo $buff, " --> " , $stream, PHP_EOL;
    while(!$found && $reads < strlen($stream) - 1) {
        $i = 0;
        $foundOccurs = 0;
        $ref = substr($buff, 1);
        while($i < strlen($buff) - 1) {
            $foundOccurs += substr_count($ref, $buff[$i]);
            $ref = substr($ref, 1);
            $i++;
        }
        if($foundOccurs > 0) {
            // pop first char
            $buff = substr($buff, 1);

            // push next character
            $buff .= $stream[$reads];
            $reads++;
        } else
            $found = true;
    }
    echo "R1 the first start-of-packet marker detected after ", $reads , " reads.", PHP_EOL;
}
?>