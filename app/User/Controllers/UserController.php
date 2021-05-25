<?php

namespace App\User\Controllers;

use App\Http\Controllers\Controller;
use App\User\Requests\CreateUserRequest;
use App\User\Requests\LoginRequest;
use App\User\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends Controller
{
    //use Validator;
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function createUser(CreateUserRequest $req)
    {
        try {
            $user = $this->userService->createUser($req->validated());
            return response()->json($user, 200);
        } catch (HttpException $e) {
            return response()->json($e->getMessage(), $e->getStatusCode());
        }
    }

    public function getUsersWithMostFavoritesInWeek() {
        $users = $this->userService->getUsersWithMostFavoritesInWeek();
        return response()->json($users, 200);
    }

    public function me() {
        return $this->userService->me();
    }

    public function login(LoginRequest $req)
    {
        try {
            $token = $this->userService->login($req->validated());
            return response()->json($token, 200);
        } catch (HttpException $e) {
            return response()->json($e->getMessage(), $e->getStatusCode());
        }
    }

    public function logout()
    {
        $response = $this->userService->logout();
        return response()->json($response, 200);
    }

    public function refresh()
    {
        $token = $this->userService->refresh();
        return response()->json($token, 200);
    }
}
