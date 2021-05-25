<?php

namespace App\User\Repositories;

use App\User\Models\User;
use App\User\Interfaces\UserRepositoryInterface;
use App\Base\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getUsersWithMostFavoritesInWeek(): Collection
    {
        $usersMostActive = $this->model->withCount(['favorites as photos_favorited' => function ($query) {
            $lastMonday = date('Y-m-d', strtotime('last monday'));
            $query->where('created_at', '>=', $lastMonday);
        }])->orderBy('photos_favorited', 'desc')->get();

        return $usersMostActive;
    }
}
