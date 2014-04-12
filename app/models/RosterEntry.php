<?php

/**
 * RosterEntry
 *
 * @property integer $id
 * @property integer $player_id
 * @property integer $map
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $roster_id
 * @property-read \User $player
 * @property-read \Roster $roster
 * @method static \Illuminate\Database\Query\Builder|\RosterEntry whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\RosterEntry wherePlayerId($value) 
 * @method static \Illuminate\Database\Query\Builder|\RosterEntry whereMap($value) 
 * @method static \Illuminate\Database\Query\Builder|\RosterEntry whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\RosterEntry whereUpdatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\RosterEntry whereRosterId($value) 
 */
class RosterEntry extends Eloquent {
  protected $table = 'roster_entry';

  public function player() {
    return $this->belongsTo('User', 'player_id');
  }
  
  public function roster() {
    return $this->belongsTo('Roster');
  }
}
