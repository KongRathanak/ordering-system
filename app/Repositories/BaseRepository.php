<?php

namespace App\Repositories;

use UnexpectedValueException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as Application;

abstract class BaseRepository {

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     *
     * @throws \Exception
     */
    public function __construct(Application $app) {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Get searchable fields array
     *
     * @return array
     */
    abstract public function getFieldsSearchable();

    /**
     * Configure the Model
     *
     * @return string
     */
    abstract public function model();

    /**
     * Make Model instance
     *
     * @throws UnexpectedValueException
     *
     * @return Model
     */
    public function makeModel() {
        $data = $this->app->make($this->model());

        if (!$data instanceof Model) {
            throw new UnexpectedValueException(
                "Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model"
            );
        }

        $this->model = $data;

        return $this->model;
    }

    /**
     * Paginate records for scaffold.
     *
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, $columns = ['*']) {
        $query = $this->allQuery();

        return $query->paginate($perPage, $columns);
    }

    /**
     * Build a query for retrieving all records.
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function allQuery($search = [], $skip = null, $limit = null) {
        $query = $this->model->newQuery();

        if (count($search)) {
            foreach($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, $value);
                }
            }
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Retrieve all records with given filter criteria
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @param array $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @return \Illuminate\Database\Eloquent\Builder[]
     * @return \Illuminate\Database\Eloquent\Collection
     *
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*']) {
        $query = $this->allQuery($search, $skip, $limit);

        return $query->get($columns);
    }

    /**
     * Create model record
     *
     * @param array $input
     *
     * @return Model
     */
    public function create($input) {
        $data = $this->model->newInstance($input);

        $data->save();

        return $data;
    }

    /**
     * Find model record for given id
     *
     * @param int $id
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder[]
     * @return \Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function find($id, $columns = ['*']) {
        $query = $this->model->newQuery();

        return $query->find($id, $columns);
    }

    /**
     * Update model record for given id
     *
     * @param array $input
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder[]
     * @return \Illuminate\Database\Eloquent\Collection|Model
     *
     */
    public function update($input, $id) {
        $query = $this->model->newQuery();

        $data = $query->findOrFail($id);

        $data->fill($input);

        $data->save();

        return $data;
    }

    /**
     * @param int $id
     *
     * @throws \Exception
     *
     * @return bool|mixed|null
     */
    public function delete($id) {
        $query = $this->model->newQuery();

        $data = $query->findOrFail($id);

        return $data->delete();
    }

    public function whereFirst($field, $value, $orderBy = []) {
        $query = $this->model->where($field, $value);

        if (count($orderBy)) {
            $query = $query->orderBy($orderBy[0], isset($orderBy[1]) ? $orderBy[1] : 'asc');
        }

        return $query->first();
    }

    public function whereExists($field, $value) {
        return $this->model->where($field, $value)->exists();
    }

}
