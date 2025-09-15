<?php

namespace App\Http\Controllers;
use App\Models\User;
class DashboardController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);
        $data['studio_count'] = User::where('user_type', 'studio')->count();
        $data['artist_count']= User::where('user_type', 'artist')->count();

        return view('pages.dashboards.index', compact('data'));
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
}
