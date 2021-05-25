<?php

namespace App\User\Interfaces;

use App\User\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function getUsersWithMostFavoritesInWeek(): Collection;
}
