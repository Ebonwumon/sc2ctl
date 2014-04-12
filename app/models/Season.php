<?php

/**
 * Season
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $start_date
 * @property string $end_date
 * @method static \Illuminate\Database\Query\Builder|\Season whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Season whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Season whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Season whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Season whereStartDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Season whereEndDate($value)
 */
class Season extends Eloquent {
  protected $guarded = array('id');
  protected $fillable = array('name', 'start_date', 'end_date');
}
