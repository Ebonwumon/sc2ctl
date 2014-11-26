<?php

namespace SC2CTL\DotCom\Controllers;

use Auth;
use Illuminate\Support\MessageBag;
use Input;
use Redirect;
use View;

class AuthController extends BaseController
{

    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return View::make('login.login');
    }


    /**
     * Authenticates a user.
     *
     * @return Redirect
     */
    public function auth() {
        $credentials = Input::only([
            'email',
            'password'
        ]);

        if (!Auth::attempt($credentials)) {
            return Redirect::route('user.login')
                ->withErrors(new MessageBag([
                    'errors' => "There was an error authenticating. Please check your email and password."
                ]));
        }

        return Redirect::route('user.profile', Auth::user()->getId());
    }

    /**
     * Displays the register form.
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        return View::make('login.register');
    }

}
