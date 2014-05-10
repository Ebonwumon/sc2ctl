<?php
/**
 * Created by PhpStorm.
 * User: ebon
 * Date: 09/05/14
 * Time: 17:44
 */

namespace domain\interf;


interface CodeRepositoryInterface {

    public function find($id);

    public function create(array $attributes);

    public function is_valid($text);

} 