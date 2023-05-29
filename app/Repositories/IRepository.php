<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    /**
     * Get the model associate to repository
     *
     * @return Model
     */
    public function getModelClass(): Model;


    /**
     * Store a new model in the database
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * Update a model in the database
     *
     * @param Model $model
     * @param array $data
     * @return Model
     */
    public function update(Model $model, array $data): Model;

    /**
     * Delete a model from the database
     *
     * @param $model int|Model
     * @return Model
     */
    public function delete(Model|int $model): Model;

    /**
     *
     * @param array $data
     * @return Builder
     */
    public function search(array $data = []): Builder;
}
