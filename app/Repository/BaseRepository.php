<?php


namespace App\Repository;


use App\Interfaces\EloquentRepositoryInterface;
use App\Traits\QueryLimit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class BaseRepository
 * @package App\Repository
 */
class BaseRepository implements EloquentRepositoryInterface
{

    use QueryLimit;
    /**
     * @var
     */
    protected $model;

    /**
     * BaseRepository constructor.
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }


    /**
     * @param array|string[] $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = [])
    {
        if (request('limit'))
            return $this->model->with($relations)->paginate($this->getQueryLimit());
        return $this->model->with($relations)->get($columns);
    }

    /**
     * @param array|string[] $columns
     * @param array $wheres
     * @param array $relations
     * @param null $limit
     * @param array $order
     * @return mixed
     */
    public function getWhere(array $columns = ['*'], array $wheres = [], array $relations = [], $limit = null, array $order = [])
    {
        $query = $this->model->with($relations);
        if (!empty($wheres))
            foreach ($wheres as $column => $value)
                $query->where($column, $value);
        if (!empty($order))
            foreach ($order as $column => $sort)
                $query->orderBy($column, $sort);
        if (!empty($limit) || request('limit'))
            return $query->paginate($this->getQueryLimit());
        return $query->get($columns);
    }

    /**
     * @return Collection
     */
    public function allTrashed(): Collection
    {
        return $this->model->onlyTrashed()->get();
    }

    /**
     * @param int $modelId
     * @param array|string[] $columns
     * @param array $relations
     * @param array $appends
     * @return Model|null
     */
    public function findByID(int $modelId, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
    {
        return $this->model->select($columns)->with($relations)->findOrFail($modelId)->append($appends);
    }

    /**
     * @param int $modelId
     * @param array|string[] $columns
     * @param array $relations
     * @return mixed
     */
    public function findFirstById(int $modelId, array $columns = ['*'], array $relations = [])
    {
        return $this->model->select($columns)->with($relations)->where('id', $modelId)->first();
    }

    /**
     * @param int $modelId
     * @return Model|null
     */
    public function findTrashedById(int $modelId): ?Model
    {
        return $this->model->withTrashed()->findOrFail($modelId);
    }

    /**
     * @param int $modelId
     * @return Model|null
     */
    public function findOnlyTrashedById(int $modelId): ?Model
    {
        return $this->model->onlyTrashed()->findOrFail($modelId);
    }

    /**
     * @param array $payload
     * @return Model|null
     */
    public function create(array $payload): ?Model
    {
        $model = $this->model->create($payload);
        return $model->fresh();
    }

    /**
     * @param int $modelId
     * @param array $payload
     * @return mixed
     */
    public function update(int $modelId, array $payload)
    {
        $model = $this->findByID($modelId);
        $model->update($payload);
        return $model->fresh();
    }

    /**
     * @param int $modelId
     * @return bool
     */
    public function deleteByID(int $modelId): bool
    {
        return $this->model->findById($modelId)->delete();
    }

    /**
     * @param int $modelId
     * @return bool
     */
    public function restoreById(int $modelId): bool
    {
        return $this->model->findOnlyTrashedById($modelId)->restore();
    }

    /**
     * @param int $modelId
     * @return bool
     */
    public function permanentlyDeleteById(int $modelId): bool
    {
        return $this->model->findTrashedById($modelId)->forceDelete();
    }

    /**
     * @return int
     */
    public function countAllData(): int
    {
        return $this->model->count('*');
    }

    /**
     * @param string $column
     * @return float
     */
    public function getAverageForColumn($column): float
    {
        return $this->model->avg($column);
    }

    /**
     * @param string $column
     * @return float
     */
    public function getSumDataAddedThisMonth($column): float
    {
        return $this->model->select('*')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum($column);
    }

}