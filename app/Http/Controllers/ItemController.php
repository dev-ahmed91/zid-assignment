<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemsRequest;
use App\Models\Item;
use App\Repository\ItemRepository;
use App\Serializers\ItemSerializer;
use App\Serializers\ItemsSerializer;
use Illuminate\Http\JsonResponse;
use App\Traits\HttpResponseStatus;
use League\CommonMark\CommonMarkConverter;

class ItemController extends Controller
{
    use HttpResponseStatus;

    public $itemsRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemsRepository = $itemRepository;
    }

    public function index()
    {
        $items = $this->itemsRepository->all();


        return JsonResponse::create(['items' => (new ItemsSerializer($items))->getData()]);
    }

    public function store(ItemsRequest $request)
    {

        $converter = new CommonMarkConverter(['html_input' => 'escape', 'allow_unsafe_links' => false]);

        $item = $this->itemsRepository->create($request->only(['name','price','url','description']));
//        $item = Item::create([
//            'name' => $request->get('name'),
//            'price' => $request->get('price'),
//            'url' => $request->get('url'),
//            'description' => $converter->convert($request->get('description'))->getContent(),
//        ]);

        $serializer = new ItemSerializer($item);


        return new JsonResponse(['item' => $serializer->getData()]);
    }

    public function show(Item $item)
    {
        $serializer = new ItemSerializer($item);

        return new JsonResponse(['item' => $serializer->getData()]);
    }

    public function update(ItemsRequest $request, Item $item): JsonResponse
    {

        //$converter = new CommonMarkConverter(['html_input' => 'escape', 'allow_unsafe_links' => false]);

//        $item->name = $request->get('name');
//        $item->url = $request->get('url');
//        $item->price = $request->get('price');
//        $item->description = $converter->convert($request->get('description'))->getContent();
//        $item->save();

        $item = $this->itemsRepository->update($item->id,$request->only(['name','price','url','description']));

        return new JsonResponse(
            [
                'item' => (new ItemSerializer($item))->getData()
            ]
        );
    }
}
