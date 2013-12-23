<?php

class Blog extends Eloquent {
	
	protected $fillable = array('title', 'message');

	public function user() {
		return $this->belongsTo('User');
	}

	public function categories() {
		return $this->belongsToMany('Category');
	}
}
