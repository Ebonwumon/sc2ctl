<?php

/**
 * Notification
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $text
 * @property string $action_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\Notification whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Notification whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Notification whereUpdatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Notification whereText($value) 
 * @method static \Illuminate\Database\Query\Builder|\Notification whereActionUrl($value) 
 */
class Notification extends Eloquent {
	
	protected $fillable = array('text', 'action_url');
	protected $guarded = array('id');
	
	public function users() {
		return $this->belongsToMany('User')->withPivot('read')->withTimestamps();
	}
}
