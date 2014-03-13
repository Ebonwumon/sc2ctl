<?php

class RosterEntry extends Eloquent {
  protected $table = 'roster_entry';

  public function player() {
    return $this->belongsTo('User', 'player_id');
  }

  public function roster() {
    return $this->belongsTo('Roster');
  }
}
