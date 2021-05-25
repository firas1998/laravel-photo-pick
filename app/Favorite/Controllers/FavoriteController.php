<?php

namespace App\Favorite\Controllers;

use App\Favorite\Interfaces\FavoriteServiceInterface;
use App\Favorite\Requests\AddRemoveFavoriteRequest;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FavoriteController extends Controller
{
    private $favoriteService;

    public function __construct(FavoriteServiceInterface $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function addFavorite(AddRemoveFavoriteRequest $req)
    {
        try {
            $favorite = $this->favoriteService->addFavorite($req->validated());
            return response()->json($favorite, 200);
        } catch (HttpException $e) {
            return response()->json($e->getMessage(), $e->getStatusCode());
        }
    }

    public function unFavorite(AddRemoveFavoriteRequest $req)
    {
        $photoId = $req->validated()['photo_id'];
        try {
            $this->favoriteService->unFavorite($photoId);
        } catch(HttpException $e) {
            return response()->json($e->getMessage(), $e->getStatusCode());
        }
    }

    public function getMostFavoritedPhotosInWeek()
    {
        try {
            $favorites = $this->favoriteService->getMostFavouritedPhotosInWeek();
            return response()->json($favorites, 200);
        } catch (HttpException $e) {
            return response()->json($e->getMessage(), $e->getStatusCode());
        }
    }

    public function isPhotoFavorited($photoId) {
        try {
            $resp = $this->favoriteService->isPhotoFavorited($photoId);
            return response()->json($resp, 200);
        } catch (HttpException $e) {
            return response()->json($e->getMessage(), $e->getStatusCode());
        }
    }
}
