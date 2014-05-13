<?php

class CodeController extends \BaseController {

    /** @var \domain\interf\CodeRepositoryInterface  */
    protected $repository;

    public function __construct(\domain\interf\CodeRepositoryInterface $repository) {
        $this->repository = $repository;
    }

	public function create()
	{
		return View::make('code/create');
	}

	public function store()
	{
        try {
            $this->repository->create(Input::all());
        } catch (\domain\exception\ValidationException $ex) {
            return Redirect::route('code.create')->withErrors($ex->get())->withInput();
        }

		return Redirect::route('giveaway.index');
	}

}
