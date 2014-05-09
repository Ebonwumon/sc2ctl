<?php

class GiveawayController extends \BaseController
{

    /** @var \domain\interf\GiveawayRepositoryInterface */
    protected $repository;

    public function __construct(\domain\interf\GiveawayRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Displays the main giveaway page.
     */
    public function index($id = null)
    {
        if ($id == null) {
            $giveaway = $this->repository->current();
        } else {
            $giveaway = $this->repository->find($id);
        }

        return View::make('giveaway/index', array('giveaway' => $giveaway));
    }

    public function enter($id)
    {
        $entries = 0;

        // Do we have access to their facebook?
        if (FB::getUser()) {
            $profile = FB::api('/me?fields=likes');
            $likeData = new FacebookLikeData($profile['likes']['data']);
            foreach (Config::get('giveaways.facebook') as $id) {
                if ($likeData->isLiked($id)) $entries++;
            }
        }

        try {
            $this->repository->create(
                array('giveaway_id' => $id,
                    'num_entries' => $entries,
                    'code' => Input::get('code'),
                    'email' => Input::get('email'),
                    'accept' => Input::get('accept'),
                    'ip_address' => Request::getClientIp()
                )
            );
        } catch (\domain\exception\ValidationException $ex) {
            return Redirect::route('giveaway.index', $id)->withErrors($ex->get());
        }

        return Redirect::route('giveaway.success', $id);



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
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


}
