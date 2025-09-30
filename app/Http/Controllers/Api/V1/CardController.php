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
             
            'is_selected' => 'boolean',
            // Stripe token created on mobile via Stripe SDK
            'stripe_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 422);
        }

        try {
            $data['user_id'] = Auth::id();
            $data['is_selected'] = (bool) $request->is_selected;
            $data['payment_type'] = 'stripe';

            // Attach external account to artist connected account
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            $user = Auth::user();
            if (!$user->stripe_account_id) {
                if (config('services.stripe.connect_stub')) {
                    $user->stripe_account_id = 'acct_stub_'.md5($user->id.'|'.now());
                    $user->save();
                } else {
                    // Auto-create a Stripe Express connected account for the artist
                    try {
                        $account = \Stripe\Account::create([
                            'type' => 'express',
                            'email' => $user->email,
                            'country' => 'US',
                            'business_type' => 'individual',
                            'capabilities' => [
                                'transfers' => ['requested' => true],
                            ],
                        ]);
                        $user->stripe_account_id = $account->id;
                        $user->save();
                    } catch (\Throwable $e) {
                        return $this->sendError('Failed to create Stripe account: '.$e->getMessage(), 422);
                    }
                }
            }

            if (config('services.stripe.connect_stub')) {
                // Stub external account without calling Stripe
                $data['stripe_external_account_id'] = 'card_stub_'.substr(md5($request->stripe_token), 0, 10);
                $data['brand'] = 'Visa';
                $data['last4'] = '4242';
                $data['exp_month'] = 12;
                $data['exp_year'] = (int) now()->addYears(3)->format('Y');
            } else {
                // Create external account (debit card) on connected account using token from mobile SDK
                $external = \Stripe\Account::createExternalAccount(
                    $user->stripe_account_id,
                    [
                        'external_account' => $request->stripe_token,
                        'default_for_currency' => true,
                    ]
                );

                // Persist only display/safe fields
                $data['stripe_external_account_id'] = $external->id;
                $data['brand'] = $external->brand ?? null;
                $data['last4'] = $external->last4 ?? null;
                $data['exp_month'] = $external->exp_month ?? null;
                $data['exp_year'] = $external->exp_year ?? null;
            }

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
            'is_selected' => 'boolean', 
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 422);
        }

        $validated = $validator->validated();
        $validated['user_id'] = Auth::id();

        $card = $this->repo->find($id, Auth::id());
        if (!$card) {
            return $this->sendError('Card not found.', 404);
        }

        // If make_default requested, set default_for_currency on Stripe and unselect others in DB
        if (!empty($validated['is_selected'])) {
            $user = Auth::user();
            if (!$user->stripe_account_id) {
                return $this->sendError('Stripe account not connected for this user.', 422);
            }

            if (!config('services.stripe.connect_stub')) {
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                // Update external account to default
                \Stripe\Account::updateExternalAccount(
                    $user->stripe_account_id,
                    $card->stripe_external_account_id,
                    ['default_for_currency' => true]
                );
            }

            // Reflect default locally
            $validated['is_selected'] = true;
        }

        $card = $this->repo->update($id, $validated, Auth::id());

        if (!$card) {
            return $this->sendError('Card not found.', 404);
        }
        return $this->sendResponse($card, 'Card updated successfully.', 200);
        try {
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong.');
        }
    }

    public function destroy($id)
    {
        try {
            $card = $this->repo->find($id, Auth::id());
            if (!$card) {
                return $this->sendError('Card not found.', 404);
            }

            // Remove external account from Stripe connected account
            $user = Auth::user();
            if ($user->stripe_account_id && $card->stripe_external_account_id && !config('services.stripe.connect_stub')) {
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                \Stripe\Account::deleteExternalAccount(
                    $user->stripe_account_id,
                    $card->stripe_external_account_id
                );
            }

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
