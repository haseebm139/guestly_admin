<?php
namespace App\Services\SpotBooking;

use App\Repositories\API\SpotBookingRepositoryInterface;
use App\Models\SpotBooking;

class SpotBookingService
{
    protected $repo;
    public function __construct(SpotBookingRepositoryInterface $repo) {

        $this->repo = $repo;

    }

    public function create(array $data){
        $data['artist_id']   = auth()->user()->id;
        $data['status']      = 'pending';
        $data['group_artists'] = json_encode($data['group_artists']);

        if (isset($data['portfolio_files']) && is_array($data['portfolio_files'])) {
            $galleryPaths = $this->uploadPortfolio($data['portfolio_files'],$data['artist_id']);

            $this->repo->savePortFolio($data['artist_id'], $galleryPaths);
        }
        
        $studio = $this->repo->findStudio($data['studio_id']);
         
        // Count approved bookings for this studio in the same date range
        $activeBookings = SpotBooking::where('studio_id', $studio->id)
            ->where('status', 'approved')
            ->where(function($q) use ($data) {
                $q->whereBetween('start_date', [$data['start_date'], $data['end_date']])
                ->orWhereBetween('end_date', [$data['start_date'], $data['end_date']]);
            })
        ->count();

        if ($activeBookings >= $studio->total_stations) {
            throw new \Exception("No stations available for this studio in the given date range.");
        }
        unset($data['portfolio_files']);


        return $this->repo->create($data);
    }
    public function paginate(int $perPage = 10){
        return $this->repo->allForCurrentUser($perPage);
    }
    public function find(int $id){
         return $this->repo->find($id);
    }
    public function reschedule(int $id, array $d)  { return $this->repo->reschedule($id, $d); }
    public function approve(int $id){ 

        $booking = SpotBooking::find($id);
        
        if (!$booking) {
            throw new \Exception("Invalid booking id.");
            
        }
        $studio = $this->repo->findStudio($booking->studio_id);
        $approvedBookings = SpotBooking::where('studio_id', $studio->id)
        ->where('status', 'approved')
        ->where(function($q) use ($booking) {
            $q->whereBetween('start_date', [$booking->start_date, $booking->end_date])
              ->orWhereBetween('end_date', [$booking->start_date, $booking->end_date]);
        })
        ->get();
         
        if ($approvedBookings->count() >= $studio->total_stations) {
            throw new \Exception("No stations available for this studio in the given date range.");
        }
        $occupiedStations = $approvedBookings->pluck('station_number')->toArray();
        $station_number = null;
        // Assign first available station
        for ($i = 1; $i <= $studio->total_stations; $i++) {
            if (!in_array($i, $occupiedStations)) {
                $station_number = $i;
                break;
            }
        }
         
        return $this->repo->approve($id,$station_number); 
    }
    public function reject(int $id)                { return $this->repo->reject($id); }


    public function uploadPortfolio(array $files,int $user_id ,int $limit = 5): array
    {
         $paths = [];

        foreach (array_slice($files, 0, $limit) as $index => $file) {
            $filename = 'artist-gallery-' . time() . '-' . $index . '.' . $file->getClientOriginalExtension();



            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // name without extension
            $extension = $file->getClientOriginalExtension();

            $file->move(public_path('artists/portfolio/'.$user_id. '/'), $filename);

            $paths['file_path'][] = 'artists/portfolio/'.$user_id . '/' . $filename;
            $paths['file_name'][] = $originalName .'.' . $extension;
            $paths['file_type'][] = $extension;
        }

        return $paths;
    }
}
