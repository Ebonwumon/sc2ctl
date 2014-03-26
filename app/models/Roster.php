<?php

class Roster extends Eloquent {
  
  const STATUS_UNSTARTED = 0;
  const STATUS_UNCONFIRMED = 1;
  const STATUS_COMPLETE = 2;

  public function lineup() {
    return $this->belongsTo('Lineup');
  }

  public function match() {
    return $this->belongsTo('Match');
  }

  public function entries() {
    return $this->hasMany('RosterEntry')->orderBy('map');
  }

  public function entry($map) {
    return $this->hasOne('RosterEntry')->where('map', '=', $map);
  }
  
  static function getIdFromMatchLineup($match_id, $lineup_id) {
    return Roster::where('match_id', '=', $match_id)->where('lineup_id', '=', $lineup_id)
                   ->select('id')->first()->id;
  }
  static function displayStatus($status) {
    if ($status == Roster::STATUS_UNSTARTED) return "Unstarted";
    if ($status == Roster::STATUS_UNCONFIRMED) return "Unconfirmed";
    if ($status == Roster::STATUS_COMPLETE) return "Complete";
    return "Unknown";
  }
}
