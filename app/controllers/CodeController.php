<?php

class CodeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('code/index');	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('code/create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		Code::create(Input::all());
		return Redirect::route('code.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function submit() {
		$code = Code::where('text', 'LIKE', Input::get('text'));
		
		if ($code->count() == 0) {
			return Response::json(array('status' => 1, 'message' => 'Sorry, code was incorrect'));
		}
		
		$code = $code->get()->first();
		if ($code->expiry < new DateTime('NOW')) {
			return Response::json(array('status' => 1, 'message' => "That code has expired"));	
		}
		$users = $code->redeemed()->where('user_id', '=', Auth::user()->id);
		if ($users->count()) {
			return Response::json(array('status' => 1, 'message' => "You've already redeemed that code!"));
		}

		$code->redeemed()->attach(Auth::user()->id);

		return Response::json(array('status' => 0));

	}

	public function winner() {
		return View::make('code/winner');
	}

	public function getWinner() {
		$date = Input::get('date');
		$codes = Code::where('expiry', '=', $date)->get();
		$users = array();
		foreach ($codes as $code) {
			$users = array_merge($users, $code->redeemed()->get()->toArray());
		}
		return Redirect::route('user.profile', $users[rand(1, count($users)) - 1]['id']);
		
	}

}
