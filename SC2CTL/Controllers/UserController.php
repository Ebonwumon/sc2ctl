<?php

namespace SC2CTL\DotCom\Controllers;

use Auth;
use Depotwarehouse\Toolbox\Exceptions\ValidationException;
use Input;
use Redirect;
use Response;
use SC2CTL\DotCom\Repositories\UserRepository;
use View;

class UserController extends BaseController
{

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * Returns a paginated list of all the users.
     *
     * @return View
     */
    public function index()
    {
        $users = $this->repository->paginate();
        return View::make('user/index')->with('users', $users);
    }

    /**
     * Show the page for a particular user.
     *
     * @param  int $id
     * @return View
     */
    public function show($id)
    {
        $user = $this->repository->find($id);
        return View::make('user.show')
            ->with('user', $user);
    }

    /**
     * Save a user record to the database.
     *
     * @return Redirect
     */
    public function store()
    {
        $attributes = Input::only($this->repository->getFillableFields());
        // We need to explicitly pull the confirmation here since it's not a field of the model, but we want to validate.
        $attributes['password_confirmation'] = Input::get('password_confirmation');

        try {
            $user = $this->repository->create($attributes);
            Auth::login($user, false);
            return Redirect::route('user.show', $user->id);

        } catch (ValidationException $exception) {
            return Redirect::route('user.register')
                ->withErrors($exception->get())
                ->withInput();
        }
    }

    /**
     * Show the form to edit a user's properties.
     *
     * @param $id
     * @return View
     */
    public function edit($id)
    {
        $user = $this->repository->find($id);

        return View::make('user.edit')
            ->with('user', $user);
    }

    /**
     * Updates a user's properties.
     *
     * @param  int $id
     * @return Redirect
     */
    public function update($id)
    {
        $attributes = Input::only($this->repository->getUpdateableFields());

        try {
            $this->repository->update($id, $attributes);
        } catch (ValidationException $exception) {
            return Redirect::route('user.edit')
                ->withErrors($exception->get())
                ->withInput();
        }

        return Redirect::route('user.show', $id);
    }


}
