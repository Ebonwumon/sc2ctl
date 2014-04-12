<?php

/**
 * SenGroup
 *
 * @property integer $id
 * @property string $name
 * @property string $permissions
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property boolean $persistent
 * @property-read \Illuminate\Database\Eloquent\Collection|\static::$userModel[] $users
 * @method static \Illuminate\Database\Query\Builder|\SenGroup whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\SenGroup whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\SenGroup wherePermissions($value)
 * @method static \Illuminate\Database\Query\Builder|\SenGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\SenGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\SenGroup wherePersistent($value)
 */
class SenGroup extends \Cartalyst\Sentry\Groups\Eloquent\Group {
  protected $table = "sengroups";
}
