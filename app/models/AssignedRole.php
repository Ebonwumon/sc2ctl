<?php

/**
 * AssignedRole
 *
 * @property-read \User $user
 * @property-read \Role $role
 */
class AssignedRole extends Eloquent {
	
	protected $table = 'assigned_roles';
	protected $fillable = array('user_id', 'role_id');
	protected $guarded = array('id');

	public function user() {
		return $this->belongsTo('User');
	}

	public function role() {
		return $this->belongsTo('Role');
	}
}
