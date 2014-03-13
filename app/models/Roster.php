<?php

class Roster extends Eloquent {
  
  const STATUS_UNSTARTED = 0;
  public function lineup() {
    return $this->belongsTo('Lineup');
  }

  public function match() {
    return $this->belongsTo('Match');
  }

  public function entries() {
    return $this->hasMany('RosterEntry')->orderBy('map');
  }

  static function displayStatus($status) {
    if ($status == Roster::STATUS_UNSTARTED) return "Unstarted";
  }
}
