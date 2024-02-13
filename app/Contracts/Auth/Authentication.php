<?php

namespace App\Contracts\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

interface Authentication
{
    //todo: update params

    /**
     * @param array $data
     * @return string
     */
    public function register(array $data): string;

    /**
     * @param string $guard
     * @return void
     */
    public function logout(string $guard): void;

    /**
     * @param Authenticatable $user
     * @return string
     */
    public function token(Authenticatable $user): string;
}
