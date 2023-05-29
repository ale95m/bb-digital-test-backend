<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class BaseRepository
{
    protected array|null $relationships = null;
    protected array $filters = [];
    protected array $select_fields = ['*'];
    protected string $split_operator = ':';
    protected string $split_relation = '->';
    protected array $sortable_fields = [];
    protected ?string $orderBy = null;
    protected bool $orderByAsc = true;
    protected bool $allow_load_deleted = false;


    public function create(array $data): Model
    {
        return $this->getModelClass()->newQuery()->create($data);
    }

    public function update(Model $model, array $data): Model
    {
        $model->update($data);
        return $model;
    }

    public function delete($model): Model
    {
        if (!is_subclass_of(Model::class,$model)) {
            $model = $this->findOrFail($model);
        }
        $model->delete();
        return $model;
    }

    /**
     * @param array $data
     * @param Builder|null $query
     * @return Builder
     */
    public function search(array $data = array(), ?Builder $query = null): Builder
    {
        if (is_null($query)) {
            $query = $this->getModelClass()->newQuery()->select($this->select_fields);
        }
        $this->loadRelations($query, $data);
        $this->loadDeletes($query, $data);
        $this->applyOrderBy($query, $data);
        $this->applyFilters($query, $data);
        return $query;
    }

    private function loadRelations(&$query, array $data)
    {
        if (!is_null($this->relationships)) {
            $query = $query->with($this->relationships);
        }
    }

    private function loadDeletes(&$query, array $data)
    {
        if ($this->allow_load_deleted) {
            if (array_key_exists('only_deleted', $data)) {
                $query = $query->onlyTrashed();
            } elseif (array_key_exists('with_deleted', $data)) {
                $query = $query->withTrashed();
            }
        }
    }

    private function applyOrderBy(&$query, array $data)
    {
        $orderBy = $data['sort_by'] ?? $this->orderBy;
        if ($orderBy != $this->orderBy) {
            if (!in_array($orderBy, $this->sortable_fields)) {
                $orderBy = $this->orderBy;
            }
        }
        if (is_null($orderBy)) {
            return;
        }
        $orderByAsc = $data['sort_asc'] ?? $this->orderByAsc;
        $query->orderBy($orderBy, $orderByAsc ? 'asc' : 'desc');
    }

    private function applyFilters(&$query, array $data)
    {
        $filter = Arr::only($data, $this->filters);
        foreach ($filter as $param => $value) {
            if (isset($filter[$param])) {
                $param = $this->filters_alias[$param] ?? $param;
                $this->addSearchParam($query, $param, $value);
            }
        }
    }
    /**
     * @param Builder $query
     * @param string $param
     * @param $value
     */
    private function addSearchParam(Builder $query, string $param, $value)
    {
        $split = explode($this->split_operator, $param, 2);
        $filterMethod = 'searchBy' . Str::studly($split[0]);
        if (method_exists(get_called_class(), $filterMethod)) {
            $this->$filterMethod($query, $value);
        } else {
            $operator = count($split) > 1 ? $split[1] : '=';
            $field = $split[0];
            $split_field = explode($this->split_relation, $field, 2);
            $relation = $split_field[0];
            if (count($split_field) > 1) {
                $this->relationCondition($query, $relation, $split_field[1], $operator, $value);
            } else {
                $this->addConditions($query, $field, $operator, $value);
            }
        }
    }
    private function relationCondition($query, string $relation, string $field, string $operator, $value)
    {
        $query->whereHas($relation, function ($query) use ($relation, $value, $operator, $field) {
            $split_relation = explode($this->split_relation, $field, 2);
            if (count($split_relation) > 1) {
                $this->relationCondition($query, $split_relation[0], $split_relation[1], $operator, $value);
            } else {
                $this->addConditions($query, $field, $operator, $value);
            }
        });
    }
    private function addConditions(&$query, string $field, string $operator, $value, $boolean = 'and')
    {
        if (is_array($value)) {
            $query->where(function ($internal_query) use ($value, $field, $operator) {
                foreach ($value as $single_value) {
                    /** @var Builder $query */
                    $this->addSingleWhere($internal_query, $field, $operator, $single_value, 'or');
                }
            });
        } else {
            $this->addSingleWhere($query, $field, $operator, $value);
        }
    }
    /**
     * @param Builder $query
     * @param string $field
     * @param string $operator
     * @param $value
     * @param string $boolean
     * @return void
     */
    private function addSingleWhere(Builder &$query, string $field, string $operator, $value, $boolean = 'and'): void
    {
        $operator == "null"
            ? ($value == true ? $query->whereNull($field) : $query->whereNotNull($field))
            : $query->where($field, $operator, $value, $boolean);
    }

    /**
     * @param $id
     * @param bool $clean
     * @return Model
     */
    function findOrFail($id, bool $clean = true): Model
    {
        if ($clean) {
            return $this->getModelClass()->newQuery()->findOrFail($id);
        } else {
            $query = $this->getModelClass()->newQuery();
            if (!is_null($this->relationships)) {
                $query->with($this->relationships);
            }
            return $query->findOrFail($id);
        }
    }
}
