<?php

class DogetipController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($confirmation = "confirmed")
	{
    if ($confirmation == "unconfirmed") {
      $dogetips = Dogetip::where('confirmed', '=', false)->get();
    } else {
      $dogetips = Dogetip::where('confirmed', '=', true)->where('paid', '=', 0)->get();
    }
    return View::make('dogetip/list', array('dogetips' => $dogetips));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id = false)
	{
    return View::make('dogetip/create', array('user_id' => $id));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
    $dogetip = new Dogetip;
    $dogetip->reciever = Input::get('reciever');
    $dogetip->tipper = Input::get('tipper');
    $dogetip->message = Input::get('message');
    $dogetip->amount = Input::get('amount');
    $dogetip->save();

    $dogetip->address = DogeAPI::getNewAddress($dogetip->id);

    $dogetip->save();

    return Redirect::route('dogetip.show', $dogetip->id);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
    $dogetip = Dogetip::find($id);

	  return View::make('dogetip/show', array('dogetip' =>$dogetip));
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

  public function scan() {
    $dogetips = Dogetip::where('confirmed', '=', false)->get();

    foreach ($dogetips as $dogetip) {
      $dogetip->verify();
    }
  }

}
