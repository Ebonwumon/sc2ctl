<?php

/**
 * Roster
 *
 * @property integer $id
 * @property integer $match_id
 * @property integer $lineup_id
 * @property boolean $confirmed
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Lineup $lineup
 * @property-read \Match $match
 * @property-read \Illuminate\Database\Eloquent\Collection|\RosterEntry[] $entries
 * @property-read \RosterEntry $entry
 * @method static \Illuminate\Database\Query\Builder|\Roster whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Roster whereMatchId($value)
 * @method static \Illuminate\Database\Query\Builder|\Roster whereLineupId($value)
 * @method static \Illuminate\Database\Query\Builder|\Roster whereConfirmed($value)
 * @method static \Illuminate\Database\Query\Builder|\Roster whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Roster whereUpdatedAt($value)
 */
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
