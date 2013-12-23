<?php

class NotificationController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('notification/create');	
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$notification = Notification::create(Input::all());
		$users = array();
		$recipients = Input::get('recipients');
		
		if (in_array('captains', $recipients)) {
			$users = array_merge($users, User::getCaptains());
		}

		if (in_array('all', $recipients)) {
			$users = User::getAll(); // We overwrite in this case
		}

		$notification->users()->sync($users);
		return Redirect::route('notification.create');
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

	public function mark($id) {
		$user = Auth::user();
		$notification = $user->notifications()->where('notification_id', '=', $id)->get()->first();
		$notification->pivot->read = true;
		$notification->pivot->save();
		return Response::json(array('status' => 0));
	}

}
