<?php

namespace App\Services;

use App\Contracts\Auth\Authentication;
use App\Services\Admin\AuthService as AdminAuthService;
use App\Services\User\AuthService as UserAuthService;
use Illuminate\Http\Request;

class AuthenticationServiceResolver
{
    /** @var Request $request */
    protected Request $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function resolve(): Authentication
    {
        $uri = $this->request->getRequestUri();

        if (strpos($uri, 'admin')) {
            return app(AdminAuthService::class);
        }

        return app(UserAuthService::class);
    }
}
