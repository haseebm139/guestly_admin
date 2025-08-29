<?php

namespace App\Http\Controllers\Api\V1\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Artist\ArtistImageService;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\FlashTattoo;
class FlashTattooController extends BaseController
{
    private $imageService;

    public function __construct(ArtistImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    // GET /api/flash-tattoos
    public function index(Request $request)
    {

        $query = FlashTattoo::query();
        $query->where('artist_id', auth()->id());
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
        }

        if ($request->has('size')) {
            $query->where('size', $request->size);
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $tattoos = $query->paginate($request->get('per_page', 10));

        return $this->sendResponse($tattoos, 'Tattoos fetched successfully.');
        try {
        } catch (\Throwable $e) {
            return $this->sendError('Something went wrong.', 500);
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'size'        => 'nullable|string',
            'repeatable'  => 'boolean',
            'price'       => 'required|numeric',
            'image'       => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'description' => 'nullable|string',
        ]);

        try {
            if ($request->hasFile('image')) {
                $data['image'] = $this->imageService->uploadImage($data['image'], 'flashTattoo', 'flashTattoos');

            }
            $data['artist_id'] = auth()->id();
            $tattoo = FlashTattoo::create($data);
            return $this->sendResponse($tattoo, 'Tattoo created successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong.', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $tattoo = FlashTattoo::find($id);
        if (!$tattoo) {
            return $this->sendError('Tattoo not found.', 404);
        }
        $data = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'size'        => 'sometimes|string',
            'repeatable'  => 'boolean',
            'price'       => 'sometimes|numeric',
            'image'       => 'sometimes|file|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'description' => 'sometimes|string',
        ]);
        try {
            if ($request->hasFile('image')) {
                $data['image'] = $this->imageService->uploadImage($data['image'], 'flashTattoo', 'flashTattoos');
            }
            $tattoo->update($data);
            return $this->sendResponse($tattoo, 'Flash Tattoo updated successfully');
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong.', 500);
        }


    }


    public function destroy($id)
    {
        $tattoo = FlashTattoo::find($id);
        if (!$tattoo) {
            return $this->sendError('Flash Tattoo not found.', 404);
        }
        $tattoo->delete();

        return response()->json([
            'message' => 'Flash Tattoo deleted successfully'
        ]);
    }

}
