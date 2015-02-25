<?php

namespace SC2CTL\DotCom\Controllers;

use Auth;
use Depotwarehouse\OAuth2\Client\Provider\BattleNet;
use Depotwarehouse\OAuth2\Client\Provider\BattleNetUser;
use Depotwarehouse\Toolbox\Exceptions\ValidationException;
use Illuminate\Support\MessageBag;
use Input;
use Log;
use Redirect;
use SC2CTL\DotCom\Repositories\BattleNetUserRepository;

class BnetAuthController extends BaseController
{

    protected $provider;

    public function __construct(BattleNet $provider, BattleNetUserRepository $repository)
    {
        $this->provider = $provider;
        $this->repository = $repository;
    }

    public function bnet_connect()
    {
        return Redirect::to($this->provider->getAuthorizationUrl());
    }

    public function bnet_auth()
    {
        // Was the OAuth return successful?
        if (Input::has('code') and $code = Input::get('code')) {
            try {
                $token = $this->provider->getAccessToken("authorization_code", [
                    'code' => $code
                ]);

                /** @var BattleNetUser $user */
                $bnet_user = $this->provider->getUserDetails($token);
                $attributes = (array)$bnet_user;
                $attributes['user_id'] = Auth::user()->id;
                // The ID field is not fillable, so we make sure to set it as bnet_id.
                $attributes['bnet_id'] = $attributes['id'];
                unset($attributes['id']);

                if ($this->repository->isAccountUsed($attributes['bnet_id'])) {
                    return Redirect::route('user.show', Auth::user()->id)
                        ->withErrors(new MessageBag([
                            'errors' => "Someone has already connected to that BNet Account"
                        ]));
                }

                $this->repository->create($attributes);

                return Redirect::route('user.show', Auth::user()->id);

            } catch (ValidationException $exception) {
                return Redirect::route('user.edit', Auth::user()->id)
                    ->withErrors($exception->get());
            } catch (\Exception $exception) {
                Log::error("Exception connecting to BNET API");
                Log::error($exception);
                return Redirect::route('user.edit', Auth::user()->id)->withErrors(new \Illuminate\Support\MessageBag([
                    'errors' => "Error connecting to BNET API: " . $exception->getMessage()
                ]));
            }
        }
        // Were there OAuth errors?
        if (Input::has('error') and $error = Input::get('error')) {
            return Redirect::route('user.edit')
                ->withErrors(new MessageBag([
                    'errors' => "Error connecting to Battle.net: {$error} - " . Input::get('error_description')
                ]));
        }

        // No code or error, something odd happened.
        return Redirect::route('user.edit', Auth::user()->id)->withErrors(new \Illuminate\Support\MessageBag(
            [ 'errors' => 'An unexpected error occured, please try again later' ]
        ));
    }

    public function ch_disconnect()
    {
        $bnet_id = Auth::user()->bnet->id;
        $this->repository->destroy($bnet_id);
        return Redirect::route('user.show', Auth::user()->id);
    }


} 
