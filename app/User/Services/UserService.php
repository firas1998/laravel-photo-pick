<?php

namespace App\User\Services;

use App\User\Models\User;
use App\User\Interfaces\UserServiceInterface;
use App\User\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserService implements UserServiceInterface
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserById($id): User
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            throw new HttpException(404, 'User not found');
        }
        return $user;
    }

    public function createUser(array $attributes): User
    {
        $attributes['password'] = Hash::make($attributes['password']);
        $user = $this->userRepository->create($attributes);
        return $user;
    }

    public function getUsersWithMostFavoritesInWeek(): Collection {
        return $this->userRepository->getUsersWithMostFavoritesInWeek();
    }

    public function login(array $credentials): array
    {
        if (! $token = auth()->attempt($credentials)) {
            throw new HttpException(401, 'Wrong email or password');
            //return response()->json(['error' => 'Unauthorized'], 401);
        }
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    public function me(): User {
        return auth()->user();
    }

    public function logout(): array
    {
        auth()->logout();
        return [
            'logout' => true,
        ];
    }

    public function refresh(): array
    {
        $token = auth()->refresh();
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
