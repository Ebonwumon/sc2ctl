<?php

namespace SC2CTL\DotCom\Controllers;

use App;
use Auth;
use Cartalyst;
use DB;
use Depotwarehouse\Toolbox\Exceptions\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\MessageBag;
use Image;
use Input;
use Log;
use Redirect;
use Request;
use Response;
use Role;
use SC2CTL\DotCom\EloquentModels\Enrollment;
use SC2CTL\DotCom\Repositories\TeamRepository;
use Sentry;
use Team;
use User;
use View;

class TeamController extends BaseController
{

    public function __construct(TeamRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Show a paginated list of all teams.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $teams = $this->repository->orderBy('name');
        return View::make('team.index')
            ->with('teams', $teams);
    }

    /**
     * Show the team creation form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return View::make('team.create');
    }

    /**
     * Store a newly created team.
     *
     * @return Redirect
     */
    public function store()
    {
        $attributes = Input::only([
            'tag',
            'name'
        ]);
        $attributes['user_id'] = Auth::user()->id; // We need to pass a user_id to attach to the Enrollment pivot

        try {
            $team = $this->repository->create($attributes);

            return Redirect::route('team.show', $team->id);

        } catch (ValidationException $exception) {
            return Redirect::route('team.create')
                ->withErrors($exception->get())
                ->withInput();
        } catch (\Exception $exception) {
            Log::error($exception);
            return Redirect::route('team.create')
                ->withErrors(new MessageBag([
                    'errors' => "Sorry, an unknown error occurred."
                ]))
                ->withInput();
        }
    }

    /**
     * Display the details of the specified Team.
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $team = $this->repository->find($id);

        return View::make('team.show')
            ->with('team', $team);
    }

    /**
     * Show the form to edit the specified Team.
     *
     * @param $id
     * @return View
     */
    public function edit($id)
    {
        $team = $this->repository->find($id);

        return View::make('team.edit')
            ->with('team', $team);
    }

    /**
     * [POST] Update the given record with new attributes.
     *
     * @param $id
     * @return Redirect
     */
    public function update($id)
    {
        $attributes = Input::only($this->repository->getUpdateableFields());

        try {
            $team = $this->repository->update($id, $attributes);
            return Redirect::route('team.show', $team->id);

        } catch (ValidationException $exception) {
            return Redirect::route('team.edit')
                ->withErrors($exception->get())
                ->withInput();
        }
    }


    /**
     * Display the form for deleting a team.
     *
     * @param $id
     * @return View
     */
    public function delete($id)
    {
        $team = $this->repository->find($id);

        return View::make('team.delete')
            ->with('team', $team);
    }

    public function destroy($id)
    {
        try {
            $this->repository->destroy($id);
        } catch (\Exception $exception) {
            Log::error("Error occurred when trying to delete team with id {$id}");
            Log::error($exception);
            return Redirect::route('team.delete', $id)
                ->withErrors(new MessageBag([
                    'errors' => "Sorry, an unknown error occurred. Please try again."
                ]));
        }

        return Redirect::route('team.index')
            ->withErrors(new MessageBag([
                'success' => "Team successfully deleted!"
            ]));
    }



}
