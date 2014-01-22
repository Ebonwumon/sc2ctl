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
    $total = file_get_contents('/home/ebon/misc/out.txt');
    $matching = ($total - 20000 > 50000) ? 50000 : $total - 20000;
    return View::make('dogecoin', array('total' => $total, 'matching' => $matching));
  }

  public function refreshdoges() {
    $val = DogeAPI::getBalance('DCqMrhmJf7no3eW5fqpsH4fU8cDsKBiqSR'); 
    return $val;
  }

  public function stream() {
    $id = Config::get('stream.current_match');
    $players = false;
    $match = false;
    if ($id) {
      $match = Match::find($id);
      $players = $match->getPlayers();
    }
    return View::make('stream', array(
          'match' => $match, 
          'channel' => Config::get('stream.channel'),
          'players' => $players,
       ));
  }

  public function getTeams() {
    $match = Match::find(Config::get('stream.current_match'));
    return View::make('user/streamDisplayPartial', array (
          'players' => $match->getPlayers(),
          'match' => $match
          ));
  }
}
