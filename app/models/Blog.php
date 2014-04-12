<?php

/**
 * Blog
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $title
 * @property string $content
 * @property integer $user_id
 * @property-read \User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\Category[] $categories
 * @method static \Illuminate\Database\Query\Builder|\Blog whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Blog whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Blog whereUpdatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Blog whereTitle($value) 
 * @method static \Illuminate\Database\Query\Builder|\Blog whereContent($value) 
 * @method static \Illuminate\Database\Query\Builder|\Blog whereUserId($value) 
 */
class Blog extends Eloquent {
	
	protected $fillable = array('title', 'message');

	public function user() {
		return $this->belongsTo('User');
	}

	public function categories() {
		return $this->belongsToMany('Category');
	}
}
