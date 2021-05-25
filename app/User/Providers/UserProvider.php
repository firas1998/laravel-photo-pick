<?php 

namespace App\User\Providers;

use App\User\Interfaces\UserRepositoryInterface;
use App\User\Interfaces\UserService;
use App\User\Interfaces\UserServiceInterface;
use App\User\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider; 

/** 
* Class RepositoryServiceProvider 
* @package App\Providers 
*/ 
class UserProvider extends ServiceProvider 
{ 
   /** 
    * Register services. 
    * 
    * @return void  
    */ 
   public function register() 
   { 
       $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
       $this->app->bind(UserServiceInterface::class, UserService::class);
   }
}