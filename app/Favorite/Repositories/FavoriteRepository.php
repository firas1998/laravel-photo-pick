<?php

namespace App\Favorite\Repositories;

use App\Base\Repositories\BaseRepository;
use App\Favorite\Interfaces\FavoriteRepositoryInterface;
use App\Favorite\Models\Favorite;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FavoriteRepository extends BaseRepository implements FavoriteRepositoryInterface
{

    /**
     * FavoriteRepository constructor.
     *
     * @param Favorite $model
     */
    public function __construct(Favorite $model)
    {
        parent::__construct($model);
    }

    public function getMostFavouritedPhotosInWeek(): Collection
    {
        $lastMonday = date('Y-m-d', strtotime('last monday'));
        $favorites = $this->model
            ->select(DB::raw('COUNT(photo_id) as times_favorited, photo_id'))
            ->where('created_at', '>=', $lastMonday)
            ->groupBy('photo_id')
            ->orderBy('times_favorited', 'DESC')
            ->get();
        return $favorites;
    }

    public function removeByPhotoIdAndUserId($photoId, $userId)
    {
        $fav = $this->model->where('photo_id', $photoId)->where('user_id', $userId)->first();
        if (!$fav) {
            throw new HttpException(404, 'This photo is not in your favorites');
        }
        $this->model->destroy($fav->first()['id']);
    }

    public function isPhotoFavorited($photoId, $userId): bool {
        return $this->model->where('photo_id', $photoId)->where('user_id', $userId)->exists();
    }
}
