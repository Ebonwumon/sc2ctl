<?php
/**
 * Created by PhpStorm.
 * User: ebon
 * Date: 09/05/14
 * Time: 16:02
 */

namespace domain\models;

use domain\exception\ValidationException;

class Giveaway extends \Eloquent {

    protected $fillable = array('name', 'description', 'close_date');
    protected $guarded = array('id');

    public function getDates() {
        return array('created_at', 'updated_at', 'close_date');
    }

    public static function validate(array $input) {
        $rules = array(
            'name' => 'required|Max:254',
            'description' => 'required',
            'close_date' => 'required|date'
        );

        $v = \Validator::make($input, $rules);

        if ($v->fails()) {
            throw new ValidationException($v);
        }
    }


}