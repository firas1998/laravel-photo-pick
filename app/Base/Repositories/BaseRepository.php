<?php

namespace App\Base\Repositories;

use App\Base\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    /**      
     * @var Model      
     */
    protected $model;

    /**      
     * BaseRepository constructor.      
     *      
     * @param Model $model      
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
    * @param $data
    * @param $id
    */
    public function update(array $data, $id): bool {
        $record = $this->find($id);
        return $record->update($data);
    }

    /**
    * @param $id
    */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
