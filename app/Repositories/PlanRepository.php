<?php
namespace App\Repositories;

use App\Models\Plan;
use App\Interfaces\PlanRepositoryInterface;
use App\Models\Feature;
class PlanRepository implements PlanRepositoryInterface
{
    public function allPlans()
    {
        return Plan::all();
    }

    public function allFeatures()
    {
        return Feature::all();
    }

    public function createPlan(array $data)
    {
        $features = $data['features'] ?? []; // extract features
        unset($data['features']); // remove before creating the plan

        $plan = Plan::create($data); // only plan columns go here

        if (!empty($features)) {
            $plan->features()->sync($features);
        }

        return $plan;

    }



    public function findPlan($id)
    {
        return Plan::with('features')->find($id);
    }

    public function updatePlan($id, array $data)
    {
        $plan = Plan::findOrFail($id);
        $features = $data['features'] ?? null;
        unset($data['features']);
        $plan->update($data);
        if (!is_null($features)) {
            $plan->features()->sync($features);
        }
        return $plan;
    }

    public function deletePlan($id)
    {
        return Plan::findOrFail($id)->delete();
    }

    public function changeStatus($id, $status)
    {
        return Plan::where('id', $id)->update(['status' => $status]);
    }
}
