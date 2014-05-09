<?php
/**
 * Created by PhpStorm.
 * User: ebon
 * Date: 09/05/14
 * Time: 17:46
 */

namespace domain\models;

class Code extends \Eloquent {

    /** @var  integer */
    public $id;

    protected $fillable = array('text', 'expiry');
    protected $guarded = array('id');

    public function getDates() {
        return array('created_at', 'updated_at', 'expiry');
    }

} 