<?php

class Day7 {
    private const INPUT = __DIR__ . "/inputd7.txt";

    static public function Round1(int $maxSize) : int {
        $totalSize = 0;
        $tree = self::input();

        foreach($tree as $file) {
            if(isset($file["files"]) && $file["size"] <= $maxSize) {

                $totalSize += $file["size"] ;
            }
        }
        return $totalSize;
    }

    static public function Round2(int $totalSpace, int $need) : int {
        $totalSize = 0;
        $tree = self::input();
        $unused = $totalSpace - $tree[0]["size"];
        $min = $tree[0]["size"];
        foreach($tree as $dir) {
            if($dir["size"] + $unused >= $need && $dir["size"] < $min) {
                $min = $dir["size"];
            }
        }
        return $min;
    }

    static private function input() : array {
        $lines = file(self::INPUT, FILE_IGNORE_NEW_LINES);
        $tree = [];
        $currentDir = null;
        foreach($lines as $line) {
            if($line[0] === '$') { // command
                $cmd = explode(" ", $line);
                if(count($cmd) > 2) { // $ cd [dir]
                    $dirname = $cmd[2];
                    if($dirname === ".." && isset($tree[$currentDir]["parent"])) {
                        $currentDir = $tree[$currentDir]["parent"];
                        $dirname = $tree[$currentDir]["name"];
                    } else if($dirname === "/") {
                        $tree[] = array("name" => $dirname, "size" => 0, "files" => [], "parent" => $currentDir);
                        $currentDir = count($tree) - 1;
                    } else {
                        $idx = self::findFileInDir($dirname, $tree[$currentDir]["files"]);
                        if($idx !== -1) {
                            $currentDir = $idx;
                        } else {
                            $tree[] = array("name" => $dirname, "size" => 0, "files" => [], "parent" => $currentDir);
                            $currentDir = count($tree) - 1;
                        }
                    }
                }
            } else {
                if(preg_match('/([0-9]+) ([\w\.]+)/', $line, $file, PREG_OFFSET_CAPTURE) === 1) {
                    if(self::findFileInDir($file[2][0], $tree[$currentDir]["files"]) === -1) {
                        array_push($tree[$currentDir]["files"], array("name" => $file[2][0], "size" => intval($file[1][0])));
                        // Update size
                        $tree[$currentDir]["size"] += intval($file[1][0]);
                        $l = $currentDir;
                        while(isset($tree[$l]["parent"])) {
                            $l = $tree[$l]["parent"];
                            $tree[$l]["size"] += intval($file[1][0]);
                        }
                    }
                } else if(preg_match('/^dir ([\w\.]+)/', $line, $dir, PREG_OFFSET_CAPTURE) === 1) {
                    $dirname = $dir[1][0];
                    if(self::findFileInDir($dirname, $tree[$currentDir]["files"]) === -1) {
                        if(!isset($tree[$currentDir])) {
                            array_push($tree[$currentDir]["files"], array("name" => $dirname, "size" => 0));
                        }
                        $tree[] = array("name" => $dirname, "size" => 0, "files" => [], "parent" => $currentDir);
                    }
                }
            }
        }
        //var_dump($tree);
        return $tree;
    }

    static function findFileInDir(string $filename, array $dir) : int {
        $i = 0;
        $found = false;
        while(!$found && $i < count($dir)) {
            if($dir[$i]["name"] === $filename) {
                $found = !$found;
            } else $i++;
        }
        if($found) {
            return $i;
        } else {
            return -1;
        }
    }
}
echo Day7::Round1(100000) , PHP_EOL;
echo Day7::Round2(70000000, 30000000) , PHP_EOL;
?>