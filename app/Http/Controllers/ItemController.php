<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ItemController extends Controller
{
    public function getItems(Request $request): AnonymousResourceCollection
    {
        $data = Item::all();
        return ItemResource::collection($data);
    }

    public function getItemDetails(Request $request, $id): ItemResource
    {
        // Tambahkan column created_by agar datanya berbeda dengan api get all item
        $data = Item::findOrFail($id);
        return new ItemResource($data);
    }

    public function deleteItem(int $id): JsonResponse
    {
        $data = Item::find($id);
        if (!$data) {
            throw new HttpResponseException(
                response()
                    ->json([
                        'errors' => [
                            'message' => 'Item not found',
                        ],
                    ])
                    ->setStatusCode(404),
            );
        }
        $data->delete();
        return response()->json(
            [
                'success' => true,
                'message' => 'Item deleted successfully',
            ],
            200,
        );
    }

    // public function StoreItem (StoreItemRequest $request): JsonResponse
    // {
    //     $data = $request->validated();
    //     $item = Item::create($data);

    //     return (new IncomingItemResource($item))->response()->setStatusCode(201);
    // }
}
