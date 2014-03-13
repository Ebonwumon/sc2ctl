<?php

class SwissRound extends Eloquent {
  
  protected $guarded = array('id');
  protected $fillable = array('due_date', 'tournament_id');

  public function matches() {
    return $this->hasMany('Match');
  }

  public function tournament() {
    return $this->belongsTo('Tournament');
  }

  public function summarize() {
    $summary = array();
    foreach ($this->matches as $match) {
      foreach ($match->score() as $k => $v) {
        $summary[] = new SwissRoundScore($k, $v['wins'], $v['losses']);
      }
    }
    return $summary;
  }
}
