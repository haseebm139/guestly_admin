<?php

namespace App\Http\Controllers\Apps\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Feature;
use Validator;
use Illuminate\Support\Str;
class FeatureManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data =Feature::all();
        return view('pages.apps.admin.plan-management.features.index',compact('data'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ]);

        if($validator->fails()){
            return redirect()->back()->with(['type'=>'error','message'=>$validator->errors()->first()]);

        }
        try {

                    $code = Str::slug($request->name, '_'); // use '_' instead of '-' if needed

                     // Check if this code already exists
                    if (Feature::where('code', $code)->exists()) {
                        return redirect()->back()->with([
                            'type' => 'error',
                            'message' => 'A feature with similar name/code already exists.',
                        ]);
                    }
                    Feature::create([
                        'name' => $request->name,
                        'code' => $code,

                    ]);

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
        $data = Feature::find($id);
        if (!isset($data)) {
            return redirect()->route('plan-management.features.index')->with(['message'=>'Data Not Found','type'=>'error']);
        }
        return view('pages.apps.admin.plan-management.features.edit', compact('data'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Feature::find($id);
        if (!isset($data)) {
            return redirect()->route('plan-management.features.index')->with(['message'=>'Data Not Found','type'=>'error']);
        }
        return view('pages.apps.admin.plan-management.features.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    try {
            $feature = Feature::find($id);

            if (!$feature) {
                return redirect()->route('plan-management.features.index')
                    ->with(['message' => 'Data Not Found', 'type' => 'error']);
            }

            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $input = [];
            $input['name'] = $request->name;

            // Auto-generate code from name (e.g. "Basic Profile" → "basic_profile")
            $generatedCode = Str::slug($request->name, '_');

            // If the generated code already exists for another feature, prevent update
            $existingFeature = Feature::where('code', $generatedCode)
                ->where('id', '!=', $feature->id)
                ->first();

            if ($existingFeature) {
                return redirect()->back()
                    ->withInput()
                    ->with(['message' => 'A feature with similar name/code already exists.', 'type' => 'error']);
            }

            $input['code'] = $generatedCode;

            $feature->update($input);

            return redirect()->route('plan-management.features.index')
                ->with(['message' => 'Feature updated successfully', 'type' => 'success']);

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
            $data = Feature::find($id);
            if (!isset($data)) {
                return redirect()->route('plan-management.features.index')->with(['message'=>'Data Not Found','type'=>'error']);
            }
            $data->delete();
            return redirect()
                ->route('plan-management.features.index')
                ->with(['message'=>'Deleted Successfully','type'=>'success']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message'=>'Something went wrong','type'=>'error']);
        }
    }
    public function change_status(Request $request)
    {
        try {
            //code...
            $statusChange = Feature::where('id',$request->id)->update(['status'=>$request->status]);
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
