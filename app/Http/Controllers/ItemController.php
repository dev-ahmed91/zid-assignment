<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemsRequest;
use App\Models\Item;
use App\Repository\ItemRepository;
use App\Serializers\ItemSerializer;
use App\Serializers\ItemsSerializer;
use App\Traits\HttpResponseStatus;
use League\CommonMark\CommonMarkConverter;

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
        $items = $this->itemsRepository->all();

        return $this->successResponse(['items'=>(new ItemsSerializer($items))->getData()]);

    }

    public function store(ItemsRequest $request)
    {

        $converter = new CommonMarkConverter(['html_input' => 'escape', 'allow_unsafe_links' => false]);

        $item = $this->itemsRepository->create($request->only(['name','price','url','description']));

        $serializer = new ItemSerializer($item);

        return $this->successResponse(['item' => $serializer->getData()]);
    }

    public function show(Item $item)
    {
        $serializer = new ItemSerializer($item);

        return $this->successResponse(['item' => $serializer->getData()]);
    }

    public function update(ItemsRequest $request, Item $item)
    {


        $item = $this->itemsRepository->update($item->id,$request->only(['name','price','url','description']));
        return $this->successResponse([
            'item' => (new ItemSerializer($item))->getData()
        ]);
    }
}
