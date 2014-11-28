<?php

namespace SC2CTL\DotCom\Validators;

use Depotwarehouse\Toolbox\DataManagement\Validators\BaseValidatorInterface;
use Depotwarehouse\Toolbox\Exceptions\ValidationException;

class TeamValidator implements BaseValidatorInterface {

    /**
     * Validates the input based on creating a new object
     * @param array $input Key-value array of keys and their inputs
     * @return void
     * @throws \Depotwarehouse\Toolbox\Exceptions\ValidationException
     */
    public static function validate(array $input)
    {
        $rules = [
            'name' => "Required|unique:teams|Between:3,128",
            "tag" => "Required|unique:teams|Between:3,6|alpha",
            "social_fb" => "url",
            "social_twitter" => "url",
            "social_twitch" => "url",
            "website" => "url"
        ];

        $v = \Validator::make($input, $rules);

        if ($v->fails()) {
            throw new ValidationException($v);
        }
    }

    /**
     * Validates the input based on updating an existing object
     * @param array $input Key-value array of keys and their inputs
     * @param mixed $current_id The ID of the current model being updated.
     * @return void
     */
    public static function updateValidate(array $input, $current_id)
    {
        // TODO: Implement updateValidate() method.
    }
}