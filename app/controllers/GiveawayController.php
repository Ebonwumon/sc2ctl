<?php

class GiveawayController extends \BaseController
{

    /** @var \domain\interf\GiveawayRepositoryInterface */
    protected $repository;

    /** @var  \domain\interf\CodeRepositoryInterface */
    protected $codeRepository;

    public function __construct(\domain\interf\GiveawayRepositoryInterface $repository, \domain\interf\CodeRepositoryInterface $codeRepository)
    {
        $this->repository = $repository;
        $this->codeRepository = $codeRepository;
    }

    /**
     * Displays the main giveaway page.
     */
    public function index($id = null)
    {
        try {
            if ($id == null) {
                $giveaway = $this->repository->current();
            } else {
                $giveaway = $this->repository->find($id);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            return View::make('giveaway/none');
        }

        return View::make('giveaway/index', array('giveaway' => $giveaway));
    }

    public function enter($id)
    {
        $entries = 0;
        if (!$this->codeRepository->is_valid(Input::get('code'))) {
            $errors = new \Illuminate\Support\MessageBag(array("The code entered is invalid or expired"));
            return Redirect::route('giveaway.index', $id)->withErrors($errors)->withInput();
        }
        // They get one entry for a valid code.
        $entries++;

        // Do we have access to their facebook?
        if (Facebook::getUser()) {
            $profile = Facebook::api('/me?fields=likes');
            $likeData = new FacebookLikeData($profile['likes']['data']);
            foreach (Config::get('giveaways.facebook') as $fb_id) {
                if ($likeData->isLiked($fb_id)) $entries++;
            }
        }

        try {
            $this->repository->enter($id,
                array('giveaway_id' => $id,
                    'num_entries' => $entries,
                    'code' => Input::get('code'),
                    'email' => Input::get('email'),
                    'accept' => Input::get('accept'),
                    'ip_address' => Request::getClientIp()
                )
            );
        } catch (\domain\exception\ValidationException $ex) {
            return Redirect::route('giveaway.index', $id)->withErrors($ex->get())->withInput();
        }

        return Redirect::route('giveaway.success', $id);

    }

    public function success($id) {
        $giveaway = $this->repository->find($id);
        return View::make('giveaway/success', array('giveaway' => $giveaway));
    }

    public function create()
    {
        return View::make('giveaway/create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        try {
            $giveaway = $this->repository->create(Input::all());
        } catch (\domain\exception\ValidationException $ex) {
            return Redirect::route('giveaway.create')->withErrors($ex->get());
        }

        return Redirect::route('giveaway.index', $giveaway->id);
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
