<?php

class GiveawayController extends \BaseController {

    /**
     * Displays the main giveaway page.
     */
    public function index()
	{
	    return View::make('giveaway/index');
	}

    public function enter() {
        $entries = 0;
        // Do we have access to their facebook?
        if (Facebook::getUser()) {
            $profile = Facebook::api('/me?fields=likes');
            $likeData = new FacebookLikeData($profile['likes']['data']);
            foreach (Config::get('giveaways.facebook') as $id) {
                if ($likeData->isLiked($id)) $entries++;
            }
        }


    }



	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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


}
