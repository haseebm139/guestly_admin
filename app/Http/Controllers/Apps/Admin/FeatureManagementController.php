<?php

namespace App\Http\Controllers\Apps\Admin;use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\FeatureRepositoryInterface;
use App\Http\Requests\StoreFeatureRequest;

class FeatureManagementController extends Controller
{
    protected $featureRepo;

    public function __construct(FeatureRepositoryInterface $featureRepo)
    {
        $this->featureRepo = $featureRepo;
    }

    public function index()
    {
        $data = $this->featureRepo->all();
        return view('pages.apps.admin.plan-management.features.index', compact('data'));
    }

    public function store(StoreFeatureRequest $request)
    {
        try {
            $this->featureRepo->create($request->only('name'));

            return redirect()->back()->with(['type' => 'success', 'message' => 'Data stored successfully']);
        } catch (\Throwable $e) {
            return redirect()->back()->with(['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        $data = $this->featureRepo->find($id);
        if (!$data) {
            return redirect()->route('plan-management.features.index')->with(['message' => 'Data Not Found', 'type' => 'error']);
        }

        return view('pages.apps.admin.plan-management.features.edit', compact('data'));
    }

    public function edit(string $id)
    {
        $data = $this->featureRepo->find($id);
        if (!$data) {
            return redirect()->route('plan-management.features.index')->with(['message' => 'Data Not Found', 'type' => 'error']);
        }

        return view('pages.apps.admin.plan-management.features.edit', compact('data'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $this->featureRepo->update($id, ['name' => $request->name]);

            return redirect()->route('plan-management.features.index')
                ->with(['message' => 'Feature updated successfully', 'type' => 'success']);
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->featureRepo->delete($id);

            return redirect()->route('plan-management.features.index')
                ->with(['message' => 'Deleted Successfully', 'type' => 'success']);
        } catch (\Throwable $e) {
            return redirect()->back()->with(['message' => 'Something went wrong', 'type' => 'error']);
        }
    }

    public function change_status(Request $request)
    {
        try {
            $updated = $this->featureRepo->changeStatus($request->id, $request->status);

            return $updated
                ? ['message' => 'Status has been changed successfully', 'type' => 'success']
                : ['message' => 'Status has not changed, please try again', 'type' => 'error'];
        } catch (\Throwable $e) {
            return ['message' => 'Something went wrong', 'type' => 'error'];
        }
    }
}
