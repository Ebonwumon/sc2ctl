<?php
/**
 * Created by PhpStorm.
 * User: ebon
 * Date: 10/05/14
 * Time: 06:39
 */

namespace domain\impl;


use domain\exception\ValidationException;
use domain\interf\CodeRepositoryInterface;
use domain\models\Code;

class CodeRepositoryEloquent implements CodeRepositoryInterface {

    /** @var \domain\models\Code  */
    protected $codeModel;

    public function __construct(Code $codeModel) {
        $this->codeModel = $codeModel;
    }

    /**
     * Find a code by its ID
     * @param integer $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function find($id)
    {
        return $this->codeModel->findOrFail($id);
    }

    /**
     * Creates a new code
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model|static
     * @throws \domain\exception\ValidationException
     */
    public function create(array $attributes)
    {
        try {
            $code = $this->codeModel->create($attributes);
        } catch (ValidationException $ex) {
            throw $ex;
        }

        return $code;
    }


    /**
     * Check if a given code is valid. Validity requires that the text exists, and that it has not yet expired.
     * @param $text
     * @return bool
     */
    public function is_valid($text)
    {
        $code_count = $this->codeModel->where('text', '=', $text)->where('expiry', '>', new \DateTime('now'))->count();
        return ($code_count) ? true : false;
    }
}