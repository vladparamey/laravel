<?php

namespace App\Services\User;

use App\Contracts\Auth\Auth;
use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class AuthService extends Auth
{
    /**
     * @param Authenticatable $user
     * @return string
     */
    public function login(Authenticatable $user): string
    {
        return $this->token($user);
    }

    /**
     * @param array $data
     * @return string
     */
    public function register(array $data): string
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $this->token($user);
    }
}
