<?php

class Category extends Eloquent {
	protected $fillable = array('name');
	public $timestamps = false;
	public function blogs() {
		return $this->belongsToMany('Blog');
	}

}
