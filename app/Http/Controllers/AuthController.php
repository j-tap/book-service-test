<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as ApiController;
use App\Services\Auth\AuthService;

class AuthController extends ApiController
{
    private $authService;

    /**
     * @param AuthorService $authorService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function registration(Request $request)
    {
        $result = $this->authService->registration($request);
        return $this->sendResponse($result);
    }

    public function login(Request $request)
    {
        $result = $this->authService->login($request);
        return $this->sendResponse($result);
    }

    /**
     * Logout
     *
     * @param  \Illuminate\Http\Request $request
     * @return json
     */
    public function logout(Request $request)
    {
        $result = $this->authService->logout($request);
        return $this->sendResponse($result);
    }
}
