<?php

namespace SC2CTL\DotCom\EloquentModels;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends \Depotwarehouse\Toolbox\DataManagement\EloquentModels\BaseModel
{

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        if ($parent instanceof User || $parent instanceof Team || $table == "team_enrollments") {
            return new Enrollment($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($parent, $attributes, $table, $exists);
    }

} 