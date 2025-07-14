<?php
namespace App\Services\SpotBooking;

use App\Repositories\API\SpotBookingRepositoryInterface;


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
    public function approve(int $id)               { return $this->repo->approve($id); }
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
        }

        return $paths;
    }
}
