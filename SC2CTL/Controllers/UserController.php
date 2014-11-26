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
        return View::make('user.profile')
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
        $attributes['password_confirmed'] = Input::get('password_confirmed');

        try {
            $user = $this->repository->create($attributes);
            Auth::login($user, false);
            return Redirect::route('user.profile', $user->id);

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

        return Redirect::route('user.profile', $id);
    }



    public function auth()
    {
        $errors = new \Illuminate\Support\MessageBag;
        try {
            Sentry::authenticate(Input::only('email', 'password'), true);

        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $errors->add('error', "Email field is required to log in");
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            $errors->add('error', "Password field is required to log in");
        } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            $errors->add('error', "User not activated");
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $errors->add('error', "Username/Password incorrect");
        } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
            $errors->add('error', "Could not authenticate. Email/Password incorrect");
        } catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            $errors->add('error', 'User is suspended due to too many login attempts');
        } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
            $errors->add('error', 'User is banned due to too many login attempts');
        }

        if ($errors->count() > 0) {
            return View::make('user/login', array( 'errors' => $errors ));
        }
        if (Session::has('redirect')) {
            $url = Session::get('redirect');
            Session::forget('redirect');
            return Redirect::to($url);
        }
        return Redirect::route('home');
    }

    public function start_reset()
    {
        return View::make('login/start_reset');
    }

    public function send_token()
    {
        $email = Input::get('email');
        $errors = new \Illuminate\Support\MessageBag;
        $user = null;
        $resetCode = null;
        try {
            $user = Sentry::findUserByLogin($email);
            $resetCode = $user->getResetPasswordCode();

        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $errors->add('error', "Email not found in database");
        }

        if ($errors->count() > 0) {
            return Redirect::route('login.start_reset')->withInput()->withErrors($errors);
        }

        Mail::send('emails.reminder', array(
                'id' => $user->id,
                'token' => $resetCode
            ),
            function ($m) use ($user) {
                $m->to($user->email)->subject("SC2CTL Password Reset");
            });

        return Redirect::route('home');
    }

    public function finalize_password($user_id, $token)
    {
        return View::make('login/finalize_password', array( 'token' => $token, 'user_id' => $user_id ));
    }

    public function complete_reset()
    {
        $errors = new \Illuminate\Support\MessageBag;

        try {
            $user = Sentry::findUserById(Input::get('user_id'));
            if ($user->checkResetPasswordCode(Input::get('token'))) {
                if ($user->attemptResetPassword(Input::get('token'), Input::get('password'))) {
                    Sentry::loginAndRemember($user);
                    return Redirect::route('home');
                } else {
                    $errors->add('error', "Password Reset failed");
                }
            } else {
                // The password reset code is invalid
                $errors->add('error', "Password reset code was invalid, please try again");
                return View::make('login/start_reset', array( 'errors', $errors ));
            }
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $errors->add('error', "User record was not found");
        }

        return View::make('login/finalize_password', array(
                'errors' => $errors,
                'token' => Input::get('token'),
                'user_id' => Input::get('user_id')
            )
        );
    }



    public function logout()
    {
        Sentry::logout();
        return Redirect::action('HomeController@index');
    }

    public function checkTaken($type, $val)
    {
        $taken = User::where($type, '=', $val)->count();
        return Response::json(array( 'taken' => $taken ));
    }

    public function search($term)
    {
        $users = User::where(DB::raw('LOWER(username)'), 'LIKE', '%' . strtolower($term) . '%');
        if (Input::has('hasTeam')) {
            if (Input::get('hasTeam') == "true") {
                $users = $users->where('team_id', '>', 0);
            } else {
                $users = $users->where('team_id', '=', 0);
            }
        }
        $users = $users->get();
        return View::make('user/multipleCardPartial', array( 'members' => $users ));
    }

}
