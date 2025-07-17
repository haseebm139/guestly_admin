<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\API\CardRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController as BaseController;
class CardController extends BaseController
{
    protected $repo;

    public function __construct(CardRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }


    public function index()
    {
        try {
            $cards = $this->repo->all(Auth::id());
            return $this->sendResponse($cards, 'Cards fetched successfully.', 201);
        } catch (\Throwable $th) {
            return $this->sendError('Error fetching cards.');
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_number' => 'required',
            'expiry_date' => 'required|date_format:m/y',
            'cvc' => 'required|digits:3',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 422);
        }

        try {
            $data['user_id'] = Auth::id();
            $data['card_number'] = $request->card_number;
            $data['expiry_date'] = $request->expiry_date;
            $data['cvc'] = $request->cvc;

            $card = $this->repo->store($data);

            if (!$card) {
                return $this->sendError('Failed to add card.', 500);
            }

            return $this->sendResponse($card, 'Card added successfully.', 201);
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong.', 500);
        }
    }

    public function show($id)
    {
        try {
            $card = $this->repo->find($id, Auth::id());

            if (!$card) {
                return $this->sendError('Card not found.', 404);
            }
            return $this->sendResponse($card, 'Card fetched successfully.', 200);

        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong.');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'card_number' => 'sometimes',
            'expiry_date' => 'sometimes|date_format:m/y',
            'cvc' => 'sometimes|digits:3',

        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 422);
        }

        try {
            $validated = $validator->validated();
            $validated['user_id'] = Auth::id();


            $card = $this->repo->update($id, $validated, Auth::id());

            if (!$card) {
                return $this->sendError('Card not found.', 404);
            }
            return $this->sendResponse($card, 'Card updated successfully.', 200);
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong.');
        }
    }

    public function destroy($id)
    {
        try {
            $card = $this->repo->delete($id, Auth::id());

            if (!$card) {
                return $this->sendError('Card not found.', 404);
            }
            return $this->sendResponse('Card deleted.', 200);

        } catch (\Throwable $th) {
             return $this->sendError('Something went wrong.');
        }
    }
}
