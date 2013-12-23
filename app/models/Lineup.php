<?php 

class Lineup extends Eloquent {
	
	
	public function historicalPlayers() {
		return $this->belongsToMany('User')->withPivot('active', 'role_id')->withTimestamps();
	}

	public function players() {
		return $this->belongsToMany('User')->withPivot('active', 'role_id')->withTimestamps()->where('active', '=', 1);
	}
}
