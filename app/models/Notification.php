<?php

class Notification extends Eloquent {
	
	protected $fillable = array('text', 'action_url');
	protected $guarded = array('id');
	
	public function users() {
		return $this->belongsToMany('User')->withPivot('read')->withTimestamps();
	}
}
