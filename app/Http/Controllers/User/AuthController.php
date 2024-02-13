<?php

namespace App\Http\Controllers\User;

use App\Contracts\Auth\Authentication;
use App\Exceptions\Auth\UserAuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\User\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @var Authentication
     */
    private Authentication $authentication;

    /**
     * @var string $guard
     */
    private string $guard = 'api';

    /**
     * @param Authentication $authentication
     */
    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws UserAuthException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (! $user && ! Hash::check($data['email'], $user->password)) {
            throw new UserAuthException();
        }

        return response()->json([
            'token' => $this->authentication->token($user)
        ]);
    }

    /**
     * @param UserRegisterRequest $request
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        return response()->json([
            'token' => $this->authentication->register($request->validated())
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->authentication->logout($this->guard);

        return response()->json();
    }


    public function test()
    {
        return 'user';
    }
}
