<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Interfaces
 */
interface EloquentRepositoryInterface
{
    /**
     * @param array|string[] $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []);

    /**
     * @param array|string[] $columns
     * @param array $wheres
     * @param array $relations
     * @param null $limit
     * @param array $order
     * @return mixed
     */
    public function getWhere(array $columns = ['*'], array $wheres = [], array $relations = [], $limit = null, array $order = []);

    /**
     * @return Collection
     */
    public function allTrashed() :Collection;

    /**
     * @param int $modelId
     * @param array|string[] $columns
     * @param array $relations
     * @param array $appends
     * @return Model|null
     */
    public function findByID(
        int $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model;

    /**
     * @param int $modelId
     * @param array|string[] $columns
     * @param array $relations
     * @return mixed
     */
    public function findFirstById(int $modelId, array $columns = ['*'], array $relations = []);

    /**
     * @param int $modelId
     * @return Model|null
     */
    public function findTrashedById(int $modelId): ?Model;

    /**
     * @param int $modelId
     * @return Model|null
     */
    public function findOnlyTrashedById(int $modelId): ?Model;

    /**
     * @param array $payload
     * @return Model|null
     */
    public function create(array $payload): ?Model;

    /**
     * @param int $modelId
     * @param array $payload
     * @return mixed
     */
    public function update(int $modelId, array $payload);

    /**
     * Delete model by id
     *
     * @param int $modelId
     * @return bool
     */
    public function deleteByID(int $modelId): bool;

    /**
     * Restore Model by id
     *
     * @param int $modelId
     * @return bool
     */
    public function restoreById(int $modelId): bool;

    /**
     * permanently delete Model by id
     * @param int $modelId
     * @return bool
     */
    public function permanentlyDeleteById(int $modelId): bool;
}