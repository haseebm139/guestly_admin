<?php

namespace App\Http\Controllers\Apps;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        
        return $dataTable->render('pages.apps.user-management.administrators.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::where('id',$id)->first();
        try {
            //code...
            if (!$user) {
                return abort(404);
            }
             
            return view('pages.apps.user-management.administrators.show', compact('user'));
        } catch (\Throwable $th) {
            return redirect()->bac()->with(['message'=>'Something went wrong','type'=>'error']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    { 
        $user = User::withTrashed()->find($id);
        $role_name = $user->roles()->first()->name ?? 'User';

        if ($user->trashed()) {
            $user->restore();
            return response()->json([
                'success' => true,
                'message' => ucfirst($role_name) . ' Restored successfully',
                'status' => 'Restored'
            ]);
        } else {
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => ucfirst($role_name) . ' Deleted successfully',
                'status' => 'Deleted'
            ]);
        }
    }
    public function myProfile(){

        try {
            //code...
            $user = auth()->user();
            return view('pages.apps.admin.profile.edit',compact('user'));
        } catch (\Throwable $th) {

            return redirect()
            ->route('myprofile')
            ->with(['message'=>'Something went worng','type'=>'error']);
        }
    }

    public function myProfileUpdateEmail(Request $request){
        try {
            //code...
            $user = auth()->user();
            $validator = Validator::make($request->all(), [

                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            ]);

            if($validator->fails()){
                return redirect()->back()->with(['type'=>'error','message'=>$validator->errors()->first()]);

            }


            $user->update([
                'email' => $request->input('email'),
                // Update more user details as needed
            ]);

            return redirect()
            ->route('myprofile')
            ->with(['message'=>'Your Email is Updated Successfully','type'=>'success']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message'=>'Something went wrong','type'=>'error']);
        }
    }
    public function myProfileUpdateName(Request $request){
        try {
            //code...
            $user = auth()->user();
            $validator = Validator::make($request->all(), [

                'name' => 'required',
            ]);

            if($validator->fails()){
                return redirect()->back()->with(['type'=>'error','message'=>$validator->errors()->first()]);

            }

            $user->update([
                'name' => $request->input('name'),
                // Update more user details as needed
            ]);

            return redirect()
            ->route('myprofile')
            ->with(['message'=>'Your Name is Updated Successfully','type'=>'success']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message'=>'Something went wrong','type'=>'error']);
        }
    }
    public function myProfileUpdatePassword(Request $request)
    {
        try {
            $user = auth()->user();


            $validator = Validator::make($request->all(), [

                'current_password' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password',
            ]);

            if($validator->fails()){
                return redirect()->back()->with(['type'=>'error','message'=>$validator->errors()->first()]);

            }
            // Check if the entered current password matches the user's actual password
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return redirect()
                ->route('myprofile')
                ->with(['message'=>'Current Password is Incorrect','type'=>'error']);
            }

            // Update the user's password
            $user->update([
                'password' => Hash::make($request->input('new_password')),
            ]);

            return redirect()
            ->route('myprofile')
            ->with(['message'=>'User Password Updated Successfully','type'=>'success']);
            //code...
        } catch (\Throwable $th) {
            return redirect()->back()->with(['message'=>'Something went wrong','type'=>'error']);

        }
    }

    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
        return response()->json([
            'success' => true,
            'status' => $user->is_active ? 'Active' : 'Inactive',
        ]);
    
    }

    public function updateVerificationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1,2',
        ]);
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ]);
            
        }
        $user->verification_status = $request->status;
        $user->save();
        $statusLabels = [
            0 => 'Pending',
            1 => 'Active',
            2 => 'Rejected',
        ];
        return response()->json([
            'success' => true,
            'status'  => $statusLabels[$user->verification_status],
        ]);
         
    }

    public function updateEmail(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ]);
            
        }
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->email = $request->email;
        $user->email_verified_at = null; // reset verification
        $user->save();

        return response()->json([
            'success' => true,
            'email'   => $user->email,
        ]);
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ]);
            
        }

        $request->validate([
            'current_password' => ['required'],
            'new_password'     => ['required', 'string', 'confirmed'],
        ]);

        // Check current password
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'The current password is incorrect.',
                ], 422); // 422 = Unprocessable Entity (validation-like error)
            }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Password updated successfully',
        ]);
    }
}
