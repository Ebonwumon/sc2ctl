<?php

class Role extends Eloquent {
	const CAPTAIN = 2;
	const MEMBER = 3;
	const OFFICER = 4;
	const NULL_ROLE = 5;
	protected $fillable = array('name');

}
