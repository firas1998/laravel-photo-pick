<?php 

namespace App\Favorite\Providers;

use App\Favorite\Interfaces\FavoriteRepositoryInterface;
use App\Favorite\Interfaces\FavoriteServiceInterface;
use App\Favorite\Repositories\FavoriteRepository;
use App\Favorite\Services\FavoriteService;
use Illuminate\Support\ServiceProvider; 

/** 
* Class FavoriteServiceProvider 
* @package App\Providers 
*/ 
class FavoriteProvider extends ServiceProvider 
{ 
   /** 
    * Register services. 
    * 
    * @return void  
    */ 
   public function register() 
   { 
       $this->app->bind(FavoriteRepositoryInterface::class, FavoriteRepository::class);
       $this->app->bind(FavoriteServiceInterface::class, FavoriteService::class);
   }
}