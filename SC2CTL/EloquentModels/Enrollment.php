<?php

namespace SC2CTL\DotCom\EloquentModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Enrollment extends Pivot {

    use SoftDeletingTrait;

    public function __construct(Model $parent, array $attributes, $table, $exists) {
        parent::__construct($parent, $attributes, $table, $exists);
    }

    protected $dates = [ 'deleted_at' ];

} 