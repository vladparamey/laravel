<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Auth\Authentication;
use App\Exceptions\Auth\AdminAuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Admin\AdminRegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin;
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
    private string $guard = 'admin';

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
     * @throws AdminAuthException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // todo: refactor
        $data = $request->validated();

        $user = Admin::where('email', $data['email'])->first();

        if (! $user && ! Hash::check($data['email'], $user->password)) {
            throw new AdminAuthException();
        }

        return response()->json([
            'token' => $this->authentication->token($user)
        ]);
    }

    /**
     * @param AdminRegisterRequest $request
     * @return JsonResponse
     */
    public function register(AdminRegisterRequest $request): JsonResponse
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
}
