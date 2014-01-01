<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index() {
		return View::make('index');
	}

	public function about() {
		return View::make('about');
	}

	public function contact() {
		return View::make('contact');
	}

	public function format() {
		return View::make('format');
	}

	public function rules() {
		return View::make('rules');
	}

	public function finals() {
		return View::make('tournament/finals');
	}

  public function dogecoin() {
    $total = file_get_contents('http://dogechain.info/chain/CHAIN/q/addressbalance/D5fFGWRiDyGNHhDq6iWCQKCaHeMfExYCam');
    return View::make('dogecoin', array('total' => $total));
  }
}
