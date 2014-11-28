<?php

namespace SC2CTL\DotCom\Controllers;
use View;

class HomeController extends BaseController
{

    public function index()
    {
        return View::make('index');
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

    public function finals()
    {
        return View::make('tournament/finals');
    }

    public function help()
    {
        return View::make('help');
    }

    public function sponsors() {
        return View::make('sponsors');
    }
}
