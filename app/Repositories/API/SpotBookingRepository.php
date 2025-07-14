<?php
namespace App\Repositories\API;

use App\Models\User;
use App\Models\SpotBooking;
use Illuminate\Support\Facades\Auth;

class SpotBookingRepository implements SpotBookingRepositoryInterface
{
    public function create(array $data)
    {

        return SpotBooking::create($data);
    }

    public function find(int $id)
    {
        return SpotBooking::with([
            'artist',
            'artist.portfolioFile',
            'studio',
        ])->find($id);
    }



    public function allForCurrentUser(int $perPage = 10)
    {
        $user = Auth::user();

        // If current user is a studio, return bookings for their studio.
        if ($user->user_type === 'studio') {
            return SpotBooking::where('studio_id', $user->id)
                 ->with(['studio:id,studio_name',
                    'artist:id', // only load artist.id
                    'artist.portfolioFile']) // load artist's portfolio files])
                ->latest()
                ->paginate($perPage);
        }

        // Else treat as artist.
        return SpotBooking::where('artist_id', $user->id)
            ->with(['studio:id,studio_name',
        'artist:id', // only load artist.id
        'artist.portfolioFile']) // load artist's portfolio files])
            ->latest()
            ->paginate($perPage);
    }

    public function reschedule(int $id, array $data)
    {
        return SpotBooking::where('id', $id)->update([
            'start_date'     => $data['start_date'],
            'end_date'       => $data['end_date'],
            'status'         => 'rescheduled',
            'rescheduled_by' => $data['rescheduled_by'], // 'artist' or 'studio'
            'reschedule_note'=> $data['reschedule_note'] ?? null,
        ]);
    }

    public function approve(int $id)
    {
        return SpotBooking::where('id', $id)->update(['status' => 'approved']);
    }

    public function reject(int $id)
    {
        return SpotBooking::where('id', $id)->update(['status' => 'rejected']);
    }


    public function savePortFolio(int $userId, array $paths): void
    {
        $user = User::findOrFail($userId);

        foreach ($paths['file_path'] as $index => $filePath) {
            $user->portfolioFile()->create([
                'file_path' => $filePath,
                'file_name' => $paths['file_name'][$index] ?? null,
                'file_type' => $paths['file_type'][$index] ?? null,
            ]);
        }
    }
}
