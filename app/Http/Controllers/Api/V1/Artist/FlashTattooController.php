<?php

namespace App\Http\Controllers\Api\V1\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\FlashTattoo;
class FlashTattooController extends BaseController
{
    // GET /api/flash-tattoos
    public function index(Request $request)
    {

        try {
            $query = FlashTattoo::query();

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
        } catch (\Throwable $e) {
            return $this->sendError('Something went wrong.', 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title'       => 'required|string|max:255',
                'size'        => 'nullable|string',
                'repeatable'  => 'boolean',
                'price'       => 'required|numeric',
                'image'       => 'nullable|string',
                'description' => 'nullable|string',
            ]);

            $tattoo = FlashTattoo::create($data);
            return $this->sendResponse($tattoo, 'Tattoo created successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong.', 500);
        }
    }


}
