<?php

namespace SC2CTL\DotCom\Controllers;
use Redirect;
use View;

class HomeController extends BaseController
{

    public function index()
    {
        return Redirect::route('home.about');
        //return View::make('index');
    }

    public function about()
    {
        return View::make('about');
    }

    public function contact()
    {
        return View::make('contact');
    }

    public function format()
    {
        return View::make('format');
    }

    public function rules()
    {
        return View::make('rules');
    }

    public function help()
    {
        return View::make('help');
    }

    public function sponsors() {
        return View::make('sponsors');
    }
}
