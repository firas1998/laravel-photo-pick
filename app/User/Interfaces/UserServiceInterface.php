<?php

namespace App\User\Interfaces;

use App\User\Models\User;

interface UserServiceInterface
{
    public function getUserById($id): User;

    public function createUser(array $attributes): User;

    public function login(array $credentials): array;

    public function logout(): array;

    public function refresh(): array;

    public function me(): User;
}
