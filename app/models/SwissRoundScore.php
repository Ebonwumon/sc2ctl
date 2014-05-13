<?php

class SwissRoundScore
{
    public $name;
    public $wins;
    public $losses;

    public function __construct($team, $wins, $losses)
    {
        $this->name = $team;
        $this->wins = $wins;
        $this->losses = $losses;
    }

    /**
     * Gets the score as a ratio of wins and losses
     * @return float Score as a ratio of wins and losses
     */
    public function scoreNumeric()
    {
        return $this->wins;
        if ($this->losses == 0) return $this->wins;
        return $this->wins / $this->losses;
    }

    /**
     * Gets the score's string representation
     * @return string Score as a string representing wins followed by losses
     */
    public function score()
    {
        return $this->wins . "-" . $this->losses;
    }

    /**
     * @param $a SwissRoundScore
     * @param $b SwissRoundScore
     * @return int
     */
    public static function sort_param($a, $b) {
        if ($a->scoreNumeric() == $b->scoreNumeric()) return 0;

        return ($a->scoreNumeric() < $b->scoreNumeric()) ? - 1 : 1;
    }

    /**
     * @param $a SwissRoundScore
     * @param $b SwissRoundScore
     * @return int
     */
    public static function reverse_sort_param($a, $b) {
        if ($a->scoreNumeric() == $b->scoreNumeric()) return 0;

        return ($a->scoreNumeric() > $b->scoreNumeric()) ? - 1 : 1;
    }

}
