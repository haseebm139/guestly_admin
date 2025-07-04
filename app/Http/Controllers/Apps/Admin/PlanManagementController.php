<?php

namespace App\Http\Controllers\Apps\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Feature;
use Validator;
class PlanManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data =Plan::all();
        $features = Feature::all();
        return view('pages.apps.admin.plan-management.plans.index',compact('data','features'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'validity_value' => 'required',
            'validity_unit' =>'required',
            'price' =>'required',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
        ]);

        if($validator->fails()){
            return redirect()->back()->with(['type'=>'error','message'=>$validator->errors()->first()]);

        }

        try {
            // Convert validity into days
            $days = match ($request->validity_unit) {
                'days' => $request->validity_value,
                'weeks' => $request->validity_value * 7,
                'months' => $request->validity_value * 30,   // Approximate
                'years' => $request->validity_value * 365,   // Approximate
                default => $validityValue,
            };
            $plan = Plan::create([
                'name' => $request->name,
                'validity_value' => $request->validity_value,
                'validity_unit' => $request->validity_unit,
                'duration_days' => $days,
                'price' => $request->price,
            ]);
            if ($request->has('features')) {
                $plan->features()->sync($request->features);
            }
            return redirect()->back()->with(['type' => 'success', 'message' => 'Data stored successfully']);
        } catch (\Throwable $e) {
            return redirect()->back()->with(['type' => 'error', 'message' => 'Something went wrong']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Plan::find($id);
        if (!isset($data)) {
            return redirect()->route('plan-management.plans.index')->with(['message'=>'Data Not Found','type'=>'error']);
        }
        return view('pages.apps.admin.plan-management.plans.edit', compact('data'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Plan::with('features')->find($id);

        $features = Feature::all();
        if (!isset($data)) {
            return redirect()->route('plan-management.plans.index')->with(['message'=>'Data Not Found','type'=>'error']);
        }
        return view('pages.apps.admin.plan-management.plans.edit', compact('data','features'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $plan = Plan::find($id);

            // Validate incoming request
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'validity_value' => 'sometimes|numeric|min:1',
                'validity_unit' => 'sometimes|in:days,weeks,months,years',
                'price' => 'sometimes|numeric|min:0',
                'features' => 'nullable|array',
                'features.*' => 'exists:features,id',
            ]);
            if($validator->fails()){
                return redirect()->back()->with(['type'=>'error','message'=>$validator->errors()->first()]);

            }

            // Prepare input array
            $input = [];

            if ($request->filled('name')) {
                $input['name'] = $request->name;
            }

            if ($request->filled('validity_value')) {
                $input['validity_value'] = $request->validity_value;
            }

            if ($request->filled('validity_unit')) {
                $input['validity_unit'] = $request->validity_unit;
            }

            if ($request->filled('price')) {
                $input['price'] = $request->price;
            }

            // Calculate and update duration_days only if either value/unit is changed
            $validityValue = $input['validity_value'] ?? $plan->validity_value;
            $validityUnit = $input['validity_unit'] ?? $plan->validity_unit;

            $input['duration_days'] = match ($validityUnit) {
                'days' => $validityValue,
                'weeks' => $validityValue * 7,
                'months' => $validityValue * 30,
                'years' => $validityValue * 365,
                default => $validityValue,
            };

            $plan->update($input);

            // Sync features if sent
            if ($request->has('features')) {
                $plan->features()->sync($request->features);
            }

            return redirect()->route('plan-management.plans.index')
            ->with(['message' => 'Plan updated successfully', 'type' => 'success']);

        } catch (\Throwable $th) {
            return redirect()->back()
                ->with(['message' => 'Something went wrong', 'type' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Plan::find($id);
            if (!isset($data)) {
                return redirect()->route('plan-management.plans.index')->with(['message'=>'Data Not Found','type'=>'error']);
            }
            $data->delete();
            return redirect()
                ->route('plan-management.plans.index')
                ->with(['message'=>'Deleted Successfully','type'=>'success']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message'=>'Something went wrong','type'=>'error']);
        }
    }
    public function change_status(Request $request)
    {
        try {
            //code...
            $statusChange = Plan::where('id',$request->id)->update(['status'=>$request->status]);
            if($statusChange)
            {
                return array('message'=>'Status has been changed successfully','type'=>'success');
            }else{
                return array('message'=>'Status has not changed please try again','type'=>'error');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message'=>'Something went wrong','type'=>'error']);
        }

    }

}
