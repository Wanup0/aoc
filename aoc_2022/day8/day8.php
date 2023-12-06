<?php

class Day8 {
    public const INPUT = __DIR__ . "/inputd8.txt";

    static public function Round1() : int {

        $lines = self::input();

        $nlines = count($lines);
        $ncols = strlen($lines[0]);

        // First line
        $visibleTrees = $nlines;
        // Last line
        $visibleTrees += $nlines;

        for($i = 1 ; $i < $nlines - 1; $i++) {

            // Borders lines : +2
            $visibleTrees += 2;
            
            $lineArr = [];
            for($c = 0; $c < $ncols ; $c++) {
                $lineArr[] = intval($lines[$i][$c]);
            }

            for($j = 1 ; $j < $ncols - 1; $j++) {
                $treeTall = intval($lines[$i][$j]);

                // line view
                $left = array_slice($lineArr, 0, $j, true); // array_slice can preserve indices
                $right = array_slice($lineArr, $j+1, $ncols - $j + 1, true);
                $keyl = array_search(max($left), $left);
                $keyr = array_search(max($right), $right);
                if($treeTall > intval($left[$keyl]) || $treeTall > intval($right[$keyr])) {
                    $visibleTrees++;
                } else {
                    // column view
                    $colArr = [];
                    for($l = 0; $l < $nlines ; $l++) {
                        $colArr[] = intval($lines[$l][$j]);
                    }
                    $left = array_slice($colArr, 0, $i, true);
                    $right = array_slice($colArr, $i+1, $nlines - $i + 1, true);
                    $keyl = array_search(max($left), $left);
                    $keyr = array_search(max($right), $right);
                    if($treeTall > intval($left[$keyl]) || $treeTall > intval($right[$keyr])) {
                        $visibleTrees++;
                    }
                }
            }
        }
        return $visibleTrees;
    }

    static public function Round2() : int {
        $scenicScore = 0;

        $lines = self::input();

        $nlines = count($lines);
        $ncols = strlen($lines[0]);
       
        $viewingDistance = function($treeHouse, $right, &$score)  {
            if(count($right) > 0) {
                $r = 0;
                $score = 1;
                if(intval($right[$r]) >= $treeHouse) return;
                while((++$r) < count($right)) {
                    $tree = intval($right[$r]);
                    $score++;
                    if($tree >= $treeHouse) {
                        return;
                    }
                }
            }
        };

        for($i = 0 ; $i < $nlines; $i++) {
            
            // Get line
            $lineArr = [];
            for($c = 0; $c < $ncols ; $c++) {
                $lineArr[] = intval($lines[$i][$c]);
            }

            for($j = 0 ; $j < $ncols; $j++) {
                $treeHouse = intval($lines[$i][$j]);
                $thisScores = ["U" => 0, "L" => 0, "R" => 0, "B" => 0];

                // Horizontal line
                // left
                $viewingDistance($treeHouse, array_reverse(array_slice($lineArr, 0, $j)), $thisScores["L"]);
                // right
                $viewingDistance($treeHouse, array_slice($lineArr, $j+1), $thisScores["R"]);

                // Vertical line
                $colArr = [];
                for($l = 0; $l < $nlines ; $l++) {
                    $colArr[] = intval($lines[$l][$j]);
                }
                // top
                $viewingDistance($treeHouse, array_reverse(array_slice($colArr, 0, $i)), $thisScores["U"]);
                // bottom
                $viewingDistance($treeHouse, array_slice($colArr, $i+1), $thisScores["B"]);

                // Best score
                $val = $thisScores["U"] * $thisScores["L"] * $thisScores["R"] * $thisScores["B"];
                if($val > $scenicScore) {
                    $scenicScore = $val;
                }
            }

        }
        return $scenicScore;
    }

    static private function input() : array {
        $lines = file(self::INPUT, FILE_IGNORE_NEW_LINES);
        return $lines;
    }
}

echo Day8::Round1() , PHP_EOL;
echo Day8::Round2() , PHP_EOL;
?>