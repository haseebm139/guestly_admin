<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        return view('pages.dashboards.index');
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
