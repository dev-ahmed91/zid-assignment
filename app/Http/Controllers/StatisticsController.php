<?php

namespace App\Http\Controllers;

use App\Repository\ItemRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public ItemRepository $itemsRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemsRepository = $itemRepository;
    }

    public function countItems(){
        $items_count = $this->itemsRepository->countAllData();
        return JsonResponse::create(['items_count' => $items_count]);
    }

    public function getItemsAveragePrice(){
        $price_average = $this->itemsRepository->getAverageForColumn('price');
        return JsonResponse::create(['price_average' => $price_average]);
    }

    public function getItemsTotalPriceThisMonth(){
        $total_price = $this->itemsRepository->getSumDataAddedThisMonth('price');
        return JsonResponse::create(['total_price' => $total_price]);
    }
}
