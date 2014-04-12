<?php

/**
 * Code
 *
 * @property integer $id
 * @property \Carbon\Carbon $expiry
 * @property string $text
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\User[] $redeemed
 * @method static \Illuminate\Database\Query\Builder|\Code whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Code whereExpiry($value) 
 * @method static \Illuminate\Database\Query\Builder|\Code whereText($value) 
 * @method static \Illuminate\Database\Query\Builder|\Code whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Code whereUpdatedAt($value) 
 */
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
