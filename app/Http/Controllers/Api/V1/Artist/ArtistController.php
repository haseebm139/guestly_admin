<?php

namespace App\Http\Controllers\Api\V1\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Artist\ArtistProfileService;
use App\Http\Requests\API\Artist\ArtistUpdateProfileRequest;
use App\Models\UserFavorite;
use App\Models\User;
use App\Models\SpotBooking;
use App\Models\ClientBookingForm;
use App\Http\Controllers\Api\BaseController as BaseController;
class ArtistController extends BaseController
{
    protected $service;

    public function __construct(ArtistProfileService  $service)
    {
        $this->service = $service;
    }
     
    public function update(ArtistUpdateProfileRequest $request)
    {
        try {

            $artist = auth()->user();
            $updatedArtist = $this->service->updateProfile($artist->id, $request->validated());
            if (!$updatedArtist) {
                return $this->sendError('Artist not found or update failed', 404);
            }

            return $this->sendResponse($updatedArtist,'Artist profile updated successfully.');
        }catch (\Throwable $th) {
            return $this->sendError('Something went wrong while updating the profile', 500);

        }
    }

    public function updateImages(ArtistUpdateProfileRequest $request)
    {
        try {
            $artist = auth()->user();
            $data = $request->validated();
            $updatedArtist = $this->service->updateProfile($artist->id, $data);
            if (!$updatedArtist) {
                return $this->sendError('Artist not found or update failed', 404);
            }
            return $this->sendResponse($updatedArtist,'Artist Images updated successfully.');
            //code...
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong while updating artist images', 500);
        }
    }

    public function show()
    {
        try {
            //code...
            $artist = auth()->user();
            $profile = $this->service->getProfile($artist->id);
            if (!$profile) {
                return $this->sendError('Artist profile not found', 404);
            }
            return $this->sendResponse(
                $profile,'Artist profile fetched successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError('Something went wrong while fetching the profile', 500);

        }
    }


    public function studios(Request $request)
    {

        $perPage = $request->get('per_page', 10);
        $filters = [
            'search'            => $request->get('search'),
            'start_date'        => $request->get('start_date'),
            'end_date'          => $request->get('end_date'),
            'studio_type'       => $request->get('studio_type'),
            'country'           => $request->get('country'),
            'station_amenities' => $request->get('station_amenities'),
        ];
        $studios = $this->service->getStudios($perPage, $filters);
        return $studios
            ? $this->sendResponse($studios, 'Studios fetched successfully.')
            : $this->sendError('No studios found.',$errorMessages = [], 404);
        try {
        } catch (\Throwable $th) {
            return $this->sendError('Failed to fetch studios.',$errorMessages = [], 500);
        }
    }

    public function bookedStudios(Request $request)
    {

        $perPage = $request->get('per_page', 10);
        $studios = $this->service->bookedStudios($perPage);
        return $studios
            ? $this->sendResponse($studios, 'Booked Studios fetched successfully.')
            : $this->sendError('No booked studios found.',$errorMessages = [], 404);
        try {
        } catch (\Throwable $th) {
            return $this->sendError('Failed to fetch booked studios.',$errorMessages = [], 500);
        }
    }

    public function studio(int $id)
    {

        try {
            $studio = $this->service->getStudio($id);

            return $studio
                ? $this->sendResponse($studio,
                                    'Studio fetched successfully.')
                : $this->sendError('Studio not found.', 404);

        } catch (\Throwable $th) {
            return $this->sendError('Failed to fetch studio.', 500);
        }
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'studio_id' => 'required|exists:users,id',
        ]);
        $result = $this->service->toggle(auth()->id(), $request->studio_id);

        if ($result['status'] == true) {
            return $this->sendResponse([],$result['message']);

        }elseif ($result['status'] == false) {
            return $this->sendError($result['message']);
        }
        return $this->sendError('Something went wrong');
    }

    public function favStudios(Request $request)
    {
        $artistId = $request->user()->id;

        $favorites = UserFavorite::where('artist_id', $artistId)
            ->with([
                'studio' => function ($q) {
                    $q->with(['supplies:id,name',
                                'stationAmenities:id,name',
                                'studioImages:id,user_id,image_path',
                                'designSpecialties:id,name',
                                'tattooStyles:id,name'
                            ]);
                }
            ])
            ->get();
        return $this->sendResponse($favorites,'Favorites fetched successfully.');
         
    }
    public function upcomingGuestSpots(Request $request)
    {
        $artistId = auth()->id(); // current logged in artist

        $bookings = ClientBookingForm::with(['studio', 'client','booking','responses.field'])
            ->where('artist_id', $artistId)
            ->where('booking_date', '>=', now()->toDateString()) // upcoming only
            ->whereIn('status', ['pending', 'approve']) // ignore draft/declined
            ->get()
            ->groupBy(function ($item) {
                return $item->studio_id . '_' . $item->booking_date;
            });

        $data = $bookings->map(function ($group) {
            return [
                'id'           => $group->first()->id,
                'studio_id'    => $group->first()->studio_id,
                'studio_name'  => $group->first()->studio?->studio_name,
                'studio_logo'  => $group->first()->studio?->studio_logo,
                'studio_country' => $group->first()->studio?->country,
                'studio_city'  => $group->first()->studio?->city,
                'studio_address'   => $group->first()->studio?->address,
                'booking_date' => $group->first()->booking_date,
                'booking' => $group->first()->booking,
                'clients'      => $group->map(function ($booking) {
                    return [
                        'client_id'   => $booking->client_id,
                        'client_name' => $booking->client?->name,
                        'client_email' => $booking->client?->email,
                        'client_avatar' => $booking->client?->avatar,
                        'status'      => $booking->status,
                        'booking_id'  => $booking->id,
                        'responses'   => $booking->responses

                    ];
                })->values(),
                'client_count'   => $group->count(),
            ];
        })->values();

        return $this->sendResponse($data, 'Upcoming guest spots fetched successfully.');

    }


    public function pastGuestSpots(Request $request)
    {
        $artistId = auth()->id(); // current logged in artist

        $bookings = ClientBookingForm::with(['studio', 'client','booking','responses.field'])
            ->where('artist_id', $artistId)
            ->where('booking_date', '<', now()->toDateString()) // past only
            ->whereIn('status', ['pending', 'approve', 'decline']) // include all except draft
            ->get()
            ->groupBy(function ($item) {
                return $item->studio_id . '_' . $item->booking_date;
            });

        $data = $bookings->map(function ($group) {
            return [
                'id'             => $group->first()->id,
                'studio_id'      => $group->first()->studio_id,
                'studio_name'    => $group->first()->studio?->studio_name,
                'studio_logo'    => $group->first()->studio?->studio_logo,
                'studio_country' => $group->first()->studio?->country,
                'studio_city'    => $group->first()->studio?->city,
                'studio_address' => $group->first()->studio?->address,
                'booking_date'   => $group->first()->booking_date,
                'booking'   => $group->first()->booking,
                'clients'        => $group->map(function ($booking) {
                    return [
                        'client_id'     => $booking->client_id,
                        'client_name'   => $booking->client?->name,
                        'client_email'  => $booking->client?->email,
                        'client_avatar' => $booking->client?->avatar,
                        'status'        => $booking->status,
                        'booking_id'    => $booking->id,
                        'responses'     => $booking->responses
                    ];
                })->values(),
                'client_count'   => $group->count(),
            ];
        })->values();

        return $this->sendResponse($data, 'Past guest spots fetched successfully.');
    }

}
