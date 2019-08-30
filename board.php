<?php

class Board
{
    private $bombs = array();
    private $board = array();
    private $keep_playing = true;

    function __construct()
    {
        for ($i = 0; $i < 25; $i++) {
            $temp = rand(1, 600);
            if (in_array($temp, $this->bombs)) { } else {
                array_push($this->bombs, $temp);
            }
        }

        for ($i = 0; $i < 20; $i++) {
            for ($j = 0; $j < 30; $j++) {
                $this->board[$i][$j] = "O";
            }
        }
    }

    function drawBoard()
    {
        echo "  (1)  (2)  (3)  (4)  (5)  (6)  (7)  (8)  (9) (10) (11) (12) (13) (14) (15) (16) (17) (18) (19) (20) (21) (22) (23) (24) (25) (26) (27) (28) (29) (30)";
        echo "\n";
        echo "\n";

        echo " | ";
        for ($i = 0; $i < 20; $i++) {
            for ($j = 0; $j < 30; $j++) {
                echo $this->board[$i][$j] . " |  ";
            }
            $x = $i + 1;
            echo "   (" . $x . ")  ";
            echo "\n";
            echo  " | ";
        }
    }
    function startNewGame()
    {
        echo "Hello are you ready to play Minesweeper";
        echo "\n";
        echo "\n";
        echo " to start enter Y to exit enter exit";
        echo "\n";
        echo "\n";

        $handle = fopen("php://stdin", "r");
        $input = fgets($handle);

        if (trim($input) == "Y") {
            $this->playingTheGame();
        } elseif (trim($input) == "exit") {
            echo "Goodbye";
        }
    }

    function playingTheGame()
    {
        while ($this->keep_playing) {
            $this->drawBoard();
            echo "\n";
            echo "here is your board 20 rows and 30 coulmns \n";
            echo "choose the cell row number \n";
            $handle = fopen("php://stdin", "r");
            $row = fgets($handle);
            echo "\n";
            echo "choose the cell coulmn number \n";
            $handle = fopen("php://stdin", "r");
            $coulmn = fgets($handle);
            echo "\n";
            echo "to mark this cell as bomb please enter (1) \n to open this cell please enter (2)\n to unmark ths cell please enter (3)";
            $handle = fopen("php://stdin", "r");
            $action = fgets($handle);
            $this->checkCell(trim($row), trim($coulmn), trim($action));
            if ($this->keep_playing) {
                echo "    check cell finished ";
            }
        }
    }

    function checkCell($row, $coulmn, $action)
    {


        switch ($action) {
            case 1:
                $this->board[$row - 1][$coulmn - 1] = "X";
                break;
            case 2:
                if (in_array((($row) * ($coulmn)), $this->bombs)) {
                    $this->youLost();
                }
                $this->checkNeighbours($row, $coulmn);
                break;
            case 3:
                if ($this->board[$row - 1][$coulmn - 1] == "X") {
                    $this->board[$row - 1][$coulmn - 1] = "O";
                }
                break;
        }
        echo "   action check finished ";
    }



    function checkNeighbours($row, $coulmn)
    {
        if ($this->countNeighbours($row, $coulmn) == 0) {
            $this->board[$row - 1][$coulmn - 1] = "_";
        } else {
            $this->board[$row - 1][$coulmn - 1] = $this->countNeighbours($row, $coulmn);
        }
    }
    function countNeighbours($row, $coulmn)
    {
        $counter = 0;

        if ($row == 1) {
            switch ($coulmn) {
                case 1:
                    if (in_array((($row) * ($coulmn + 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row + 1) * ($coulmn + 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row + 1) * ($coulmn)), $this->bombs)) {
                        $counter++;
                    }
                    break;
                case 30:
                    if (in_array((($row) * ($coulmn - 1)), $this->bombs)) {
                        $counter++;
                    }

                    if (in_array((($row - 1) * ($coulmn - 1)), $this->bombs)) {
                        $counter++;
                    }

                    if (in_array((($row + 1) * ($coulmn)), $this->bombs)) {
                        $counter++;
                    }
                    break;
                default:
                    if (in_array((($row) * ($coulmn - 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row) * ($coulmn + 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row + 1) * ($coulmn - 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row + 1) * ($coulmn)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row + 1) * ($coulmn + 1)), $this->bombs)) {
                        $counter++;
                    }
                    break;
            }
        } elseif ($row == 20) {
            switch ($coulmn) {
                case 1:
                    if (in_array((($row - 1) * ($coulmn)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row - 1) * ($coulmn + 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row) * ($coulmn + 1)), $this->bombs)) {
                        $counter++;
                    }
                    break;
                case 30:
                    if (in_array((($row - 1) * ($coulmn)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row - 1) * ($coulmn - 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row) * ($coulmn - 1)), $this->bombs)) {
                        $counter++;
                    }
                    break;
                default:
                    if (in_array((($row) * ($coulmn - 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row - 1) * ($coulmn - 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row - 1) * ($coulmn)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row - 1) * ($coulmn + 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row) * ($coulmn + 1)), $this->bombs)) {
                        $counter++;
                    }
                    break;
            }
        } elseif (1 > $row || $row > 20 || $coulmn < 1 || $coulmn > 30) {
            echo "error";
        } elseif (1 > $row && $row < 20) {
            switch ($coulmn) {
                case 1:
                    if (in_array((($row + 1) * ($coulmn)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row + 1) * ($coulmn + 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row) * ($coulmn + 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row - 1) * ($coulmn + 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row + 1) * ($coulmn)), $this->bombs)) {
                        $counter++;
                    }
                    break;
                case 30:
                    if (in_array((($row - 1) * ($coulmn)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row - 1) * ($coulmn - 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row) * ($coulmn - 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row + 1) * ($coulmn - 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row + 1) * ($coulmn)), $this->bombs)) {
                        $counter++;
                    }
                    break;
                default:
                    if (in_array((($row - 1) * ($coulmn - 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row) * ($coulmn - 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row + 1) * ($coulmn - 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row - 1) * ($coulmn)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row + 1) * ($coulmn)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row - 1) * ($coulmn + 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row) * ($coulmn + 1)), $this->bombs)) {
                        $counter++;
                    }
                    if (in_array((($row + 1) * ($coulmn + 1)), $this->bombs)) {
                        $counter++;
                    }
                    break;
            }
        }
        echo "counted";
        return $counter;
    }
    function youLost()
    {
        echo " you have clicked a bomb -_-! sorry";
        $this->keep_playing = false;
    }
}
