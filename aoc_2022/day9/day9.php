<?php

class Day9 {
    public const INPUT = __DIR__ . "/inputd9.txt";

    static public function Round1() : int {
        $visitedPositionsOnceByTail = 0;
        $cmds = self::input();

        $grid = [[1]]; // same position overlapping  x = cols, y = lines

        $visit = function(&$grid, $dir, &$hx, &$hy, &$tx, &$ty) {
            $move = 0;
            if($dir === "R") {
                // update T
                if($tx === $hx - 1) { // tail is x-1 of head
                    $tx++;
                    $ty = $hy;
                    $move = 1;
                }
                //update H
                $hx++;
                if(!isset($grid[$hx][$hy])) {
                    array_push($grid, array_fill(0, count($grid[0]), 0));
                }
            } else if($dir === "L") {
                // update T
                if($tx === $hx + 1) { // tail is x-1 of head
                    $tx--;
                    $ty = $hy;
                    $move = 1;
                }
                //update H
                if($hx === 0) {
                    array_unshift($grid, array_fill(0, count($grid[0]), 0));
                    $tx++;
                } else {
                    $hx--;
                }
            } else if($dir === "U") {
                // update T
                if($ty > $hy) { // tail is y+1 of head
                    $ty--;
                    $tx = $hx;
                    $move = 1;
                }
                if($hy === 0) {
                    for($c = 0; $c < count($grid); $c++) {
                        array_unshift($grid[$c], 0);
                    }
                    $ty++;
                } else {
                    $hy--;
                }
            } else { // $dir === "D"
                if($ty === $hy - 1) {
                    $ty++;
                    $tx = $hx;
                    $move = 1;
                }
                $hy++;
                if(!isset($grid[$hx][$hy])) {
                    for($c = 0; $c < count($grid); $c++) {
                        array_push($grid[$c], 0);
                    }
                }
            }
            // mark visited
            $grid[$tx][$ty] += $move;
        };

        $hx = $tx = $hy = $ty = 0;
        foreach($cmds as $c) {
            for($i = $c[1]; $i > 0; $i--) {
                $visit($grid, $c[0], $hx, $hy, $tx, $ty);
            }
        }
        //$grid = [[1, 4], [2, 3]];
        for($line = 0; $line < count($grid[0]); $line++) {
            foreach($grid as $col) {
                echo $col[$line] . "|" ;
                if($col[$line] > 0) $visitedPositionsOnceByTail++;
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
        return $visitedPositionsOnceByTail;
    }
    static public function Round2() : int {
        $scenicScore = 0;
        $lines = self::input();
        return $scenicScore;
    }

    static private function input() : array {
        $lines = file(self::INPUT, FILE_IGNORE_NEW_LINES);
        $cmds = array_map(fn($line) => [ explode(" ", $line)[0] , intval(explode(" ", $line)[1]) ], $lines);
        //var_dump($cmds);
        return $cmds;
    }
}

echo Day9::Round1() , PHP_EOL;
//echo Day9::Round2() , PHP_EOL;
?>