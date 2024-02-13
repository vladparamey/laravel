<?php

namespace App\Contracts\Auth;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth as AuthFacade;

abstract class Auth implements Authentication
{
    /**
     * @var string|Repository|Application|\Illuminate\Foundation\Application|mixed
     */
    private string $api_token;

    public function __construct()
    {
        $this->api_token = config('auth.api_token');
    }

    /**
     * @param Authenticatable $user
     * @return string
     */
    public function token(Authenticatable $user): string
    {
        return $user->createToken($this->api_token)->plainTextToken;
    }

    /**
     * @param string $guard
     * @return void
     */
    public function logout(string $guard): void
    {
        AuthFacade::guard($guard)->user()->currentAccessToken()->delete();
    }
}
