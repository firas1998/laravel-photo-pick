<?php

namespace App\Favorite\Services;

use App\Favorite\Interfaces\FavoriteServiceInterface;
use App\Favorite\Models\Favorite;
use App\Favorite\Repositories\FavoriteRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FavoriteService implements FavoriteServiceInterface
{

    private $favoriteRepository;

    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function getFavoriteById($id): Favorite
    {
        $favorite = $this->favoriteRepository->find($id);
        if (!$favorite) {
            throw new HttpException(404, 'Photo not found');
        }
        return $favorite;
    }

    public function addFavorite(array $attributes): Favorite
    {
        $user = auth()->user();
        $attributes['user_id'] = $user->id;
        try {
            $favorite = $this->favoriteRepository->create($attributes);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                throw new HttpException(422, 'You already added this photo to your favorites');
            }
            throw new HttpException(500, 'Server error');
        }
        return $favorite;
    }

    public function unFavorite($photoId)
    {
        $user = auth()->user();
        $favorite = $this->favoriteRepository->removeByPhotoIdAndUserId($photoId, $user->id);
    }

    public function getMostFavouritedPhotosInWeek(): Collection
    {
        $today = date('D');

        if ($today !== 'Sun' && $today !== 'Sat') {
            //throw new HttpException(422, 'You can only view this page Saturday and Sunday');
        }
        return $this->favoriteRepository->getMostFavouritedPhotosInWeek();
    }

    public function isPhotoFavorited($photoId): array
    {
        $user = auth()->user();
        $res = $this->favoriteRepository->isPhotoFavorited($photoId, $user->id);
        return ['favorited' => $res];
    }
}
