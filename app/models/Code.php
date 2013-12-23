<?php

class Code extends Eloquent {
	
	protected $fillable = array('text', 'expiry');
	protected $guarded = array('id');

	public function redeemed() {
		return $this->belongsToMany('User');
	}
	
	public function getDates() {
		return array('created_at', 'updated_at', 'expiry');
	}

}
