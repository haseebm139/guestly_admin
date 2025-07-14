<?php
namespace App\Repositories\API\Studio;

use Illuminate\Support\Arr;
use App\Models\BoostAd;




class BoostAdRepository implements BoostAdRepositoryInterface
{
    public function create(array $data)
    {
        $data['start_date'] = now();
        $data['end_date'] = now()->addDays($data['duration_days']);
        return BoostAd::create($data);
    }

    public function getByStudio($studioId)
    {
        return BoostAd::where('user_id', $studioId)
            ->orderByDesc('created_at')
            ->get();
    }

    public function stop($id, $studioId)
    {
        $ad = BoostAd::where('id', $id)
            ->where('user_id', $studioId)
            ->where('status', 'in_process')
            ->first();

        if ($ad) {
            $ad->status = 'completed';
            $ad->save();
        }

        return $ad;
    }

    public function boostAgain($id, $studioId)
    {
        $oldAd = BoostAd::where('id', $id)
            ->where('user_id', $studioId)
            ->first();

        if ($oldAd) {
            return $this->create([
                'user_id' => $studioId,
                'duration_days' => $oldAd->duration_days,
                'budget' => $oldAd->budget,
            ]);
        }

        return null;
    }

    public function getActiveBoostAd($studioId){

        return BoostAd::where('user_id', $studioId)
        ->where('status', 'in_process')
        ->where(function ($query) {
            $query->where(function ($q) {
                $q->whereDate('start_date', '<=', now())
                  ->whereDate('end_date', '>=', now());
            })
            ->orWhere(function ($q) {
                // fallback condition, example: boost starts in future
                $q->whereDate('start_date', '>', now());
            });
        })
        ->orderBy('start_date', 'desc') // latest by start date
        ->first();
     }

     public function getUnactiveBoostAd($studioId)
    {
        return BoostAd::where('user_id', $studioId)
            ->where('status', 'in_process')
            ->where(function ($query) {
                $query->whereDate('end_date', '<', now()) // Expired
                    ->orWhereDate('start_date', '>', now()); // Not started yet
            })
            ->get();
    }
}
