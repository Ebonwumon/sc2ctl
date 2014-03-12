<?php

class SwissRoundScore {
  public $name;
  public $wins;
  public $losses;

  public function __construct($team, $wins, $losses) {
    $this->name = $team;
    $this->wins = $wins;
    $this->losses = $losses;
  }

  public function scoreNumeric() {
    return $this->wins / $this->losses;
  }

  public function score() {
    return $this->wins . "-" . $this->losses;
  }
}
