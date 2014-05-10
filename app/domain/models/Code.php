<?php
/**
 * Created by PhpStorm.
 * User: ebon
 * Date: 09/05/14
 * Time: 17:46
 */

namespace domain\models;


use domain\exception\ValidationException;

class Code extends \Eloquent {

    protected $fillable = array('text', 'expiry');
    protected $guarded = array('id');

    public function getDates() {
        return array('created_at', 'updated_at', 'expiry');
    }

    public static function validate(array $input) {
        $rules = array(
            'text' => 'required|unique:codes,text',
            'expiry' => 'required|date'
        );

        $v = \Validator::make($input, $rules);
        if ($v->fails()) {
            throw new ValidationException($v);
        }
    }

} 