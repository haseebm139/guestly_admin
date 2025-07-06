<?php

namespace App\Http\Controllers\Apps\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\PlanRepositoryInterface;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;

use Validator;
class PlanManagementController extends Controller
{
    protected $planRepo;

    public function __construct(PlanRepositoryInterface $planRepo)
    {
        $this->planRepo = $planRepo;
    }

    public function index()
    {
        $data = $this->planRepo->allPlans();
        $features = $this->planRepo->allFeatures();
        return view('pages.apps.admin.plan-management.plans.index', compact('data', 'features'));
    }

    public function store(StorePlanRequest $request)
    {
        try {

            $data = $request->validated();
            // $data['duration_days'] = calculate_duration_days($data['validity_value'], $data['validity_unit']);
            // $data['duration_days'] = calculate_duration_days($data['validity_value'], $data['validity_unit']);
            $this->planRepo->createPlan($data);
            return redirect()->back()->with(['type' => 'success', 'message' => 'Data stored successfully']);
        } catch (\Throwable $e) {
            return redirect()->back()->with(['type' => 'error', 'message' => 'Something went wrong']);
        }
    }

    public function show(string $id)
    {
        $data = $this->planRepo->findPlan($id);
        if (!$data) {
            return redirect()->route('plan-management.plans.index')->with(['message' => 'Data Not Found', 'type' => 'error']);
        }
        return view('pages.apps.admin.plan-management.plans.edit', compact('data'));
    }

    public function edit(string $id)
    {
        $data = $this->planRepo->findPlan($id);
        $features = $this->planRepo->allFeatures();

        if (!$data) {
            return redirect()->route('plan-management.plans.index')->with(['message' => 'Data Not Found', 'type' => 'error']);
        }

        return view('pages.apps.admin.plan-management.plans.edit', compact('data', 'features'));
    }

    public function update(UpdatePlanRequest $request, string $id)
    {

        //code...
        $plan = $this->planRepo->findPlan($id);

        $plan->fill($request->only([
            'name',
            'm_price',
            'y_price',
        ]));

        // $plan->duration_days = calculate_duration_days($plan->validity_value, $plan->validity_unit);

        if ($request->has('features')) {
            $plan->features()->sync($request->features);
        }

        $plan->save();
        return redirect()->route('plan-management.plans.index')
            ->with(['message' => 'Plan updated successfully', 'type' => 'success']);
        try {
        } catch (\Throwable $th) {
             return redirect()->back()->with(['message' => 'Something went wrong', 'type' => 'error']);

        }

    }

    public function destroy(string $id)
    {
        try {
            $this->planRepo->deletePlan($id);
            return redirect()->route('plan-management.plans.index')
                ->with(['message' => 'Deleted Successfully', 'type' => 'success']);
        } catch (\Throwable $e) {
            return redirect()->back()->with(['message' => 'Something went wrong', 'type' => 'error']);
        }
    }

    public function change_status(Request $request)
    {
        try {
            $updated = $this->planRepo->changeStatus($request->id, $request->status);
            if ($updated) {
                return ['message' => 'Status has been changed successfully', 'type' => 'success'];
            } else {
                return ['message' => 'Status has not changed, please try again', 'type' => 'error'];
            }
        } catch (\Throwable $e) {
            return ['message' => 'Something went wrong', 'type' => 'error'];
        }
    }
}
