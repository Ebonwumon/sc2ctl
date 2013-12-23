<?php

class Map extends Eloquent {
	
	protected $fillable = array('name', 'path');
	protected $guarded = array('id');

	public $timestamps = false;

}
