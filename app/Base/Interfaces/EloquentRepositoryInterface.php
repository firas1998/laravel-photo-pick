<?php

namespace App\Base\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
* Interface EloquentRepositoryInterface
* @package App\Repositories
*/
interface EloquentRepositoryInterface
{


   /**
    * @return Collection
    */
   public function all(): Collection;

   /**
    * @param array $attributes
    * @return Model
    */
   public function create(array $attributes): Model;

   /**
    * @param $id
    * @return Model
    */
   public function find($id): ?Model;

   /**
    * @param $data
    * @param $id
    */
   public function update(array $data, $id): bool;

    /**
    * @param $id
    */
   public function delete($id);
}