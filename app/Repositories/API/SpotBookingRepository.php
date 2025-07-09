<?php
namespace App\Repositories\API;

class SpotBookingRepository implements SpotBookingRepositoryInterface
{
    public function create(array $data): SpotBooking
    {
        return SpotBooking::create($data);
    }

    public function find(int $id): ?SpotBooking
    {
        return SpotBooking::with([
            'artist:id,name',
            'studio:id,studio_name',
            'groupArtists:id,name',
        ])->find($id);
    }

    public function allForCurrentUser(int $perPage = 10)
    {
        $user = Auth::user();

        // If current user is a studio, return bookings for their studio.
        if ($user->user_type === 'studio') {
            return SpotBooking::where('studio_id', $user->id)
                ->with(['artist:id,name'])
                ->latest()
                ->paginate($perPage);
        }

        // Else treat as artist.
        return SpotBooking::where('artist_id', $user->id)
            ->with(['studio:id,studio_name'])
            ->latest()
            ->paginate($perPage);
    }

    public function reschedule(int $id, array $data): bool
    {
        return SpotBooking::where('id', $id)->update([
            'start_date'     => $data['start_date'],
            'end_date'       => $data['end_date'],
            'status'         => 'rescheduled',
            'rescheduled_by' => $data['rescheduled_by'], // 'artist' or 'studio'
            'reschedule_note'=> $data['reschedule_note'] ?? null,
        ]);
    }

    public function approve(int $id): bool
    {
        return SpotBooking::where('id', $id)->update(['status' => 'approved']);
    }

    public function reject(int $id): bool
    {
        return SpotBooking::where('id', $id)->update(['status' => 'rejected']);
    }
}
