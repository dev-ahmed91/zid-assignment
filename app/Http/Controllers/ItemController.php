<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemsRequest;
use App\Http\Resources\ItemsResource;
use App\Models\Item;
use App\Repository\ItemRepository;
use App\Serializers\ItemSerializer;
use App\Traits\HttpResponseStatus;
use Illuminate\Http\JsonResponse;

class ItemController extends Controller
{
    use HttpResponseStatus;

    public ItemRepository $itemsRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemsRepository = $itemRepository;
    }

    public function index()
    {
        $items = ItemsResource::collection($this->itemsRepository->all());
        return JsonResponse::create(['items' => $items]);
    }

    public function store(ItemsRequest $request)
    {
        $this->logInfo(__METHOD__);
        try {
            $item = $this->itemsRepository->create($request->only(['name','price','url','description']));
            return new JsonResponse(['item' => $item]);
        }catch (\Exception $e){
            return JsonResponse(["errors"   => ["exception" => "Error on saving data. Error Code: " .$this->logError(__METHOD__, $e)]], 500);
        }
    }

    public function show(Item $item)
    {
        $item_details = new ItemsResource($item);
        return new JsonResponse(['item' => $item_details]);
    }

    public function update(ItemsRequest $request, Item $item)
    {
        $this->logInfo(__METHOD__);
        try {
            $item = $this->itemsRepository->update($item->id,$request->only(['name','price','url','description']));
            return new JsonResponse(
                [
                    'item' => new ItemsResource($item)
                ]
            );
        }catch (\Exception $e){
            return JsonResponse(["errors"   => ["exception" => "Error on updating data. Error Code: " .$this->logError(__METHOD__, $e)]], 500);
        }
    }
}
