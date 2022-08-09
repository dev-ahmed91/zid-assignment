<?php


namespace App\Repository;

use App\Models\Item;
use App\Repository\BaseRepository;

/**
 * Class StarRepository
 * @package App\Repository
 */
class ItemRepository extends BaseRepository
{
    /**
         * @var Model
     */
    protected $model;

    /**
     * StarRepository constructor.
     * @param $model
     */
    public function __construct(Item $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

}