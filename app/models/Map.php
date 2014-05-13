<?php

/**
 * Map
 *
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property boolean $active
 * @method static \Illuminate\Database\Query\Builder|\Map whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Map whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Map wherePath($value)
 */
class Map extends Eloquent {
	
	protected $fillable = array('name', 'path', 'active');
	protected $guarded = array('id');

	public $timestamps = false;


}
