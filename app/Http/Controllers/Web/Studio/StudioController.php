<?php

namespace App\Http\Controllers\Web\Studio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    public function home()
    {
        return view('user.dashboard.studio.studio_home', [
            'pageTitle' => 'Studio Dashboard'
        ]);
    }

    public function chat()
    {
        return view('user.dashboard.studio.studio_chat', [
            'pageTitle' => 'Messages'
        ]);
    }

    public function searchArtist()
    {
        return view('user.dashboard.studio.studio_search_artist', [
            'pageTitle' => 'Guest Artist Search'
        ]);
    }
    public function studioRequest()
    {
        return view('user.dashboard.studio.studio_request', [
            'pageTitle' => 'Guest Artist Request'
        ]);
    }
    public function studioSubscription()
    {
        return view('user.dashboard.studio.studio_subscription', [
            'pageTitle' => 'Profile Management'
        ]);
    }
    public function studioAvailability()
    {
        return view('user.dashboard.studio.studio_availability', [
            'pageTitle' => 'Profile Management'
        ]);
    }
    public function studioPromotion()
    {
        return view('user.dashboard.studio.studio_promotion', [
            'pageTitle' => 'Profile Management'
        ]);
    }

    public function profile()
    {
        return view('user.dashboard.studio.studio_profile', [
            'pageTitle' => 'Profile Management'
        ]);
    }

    public function rating()
    {
        return view('user.dashboard.studio.studio_rating', [
            'pageTitle' => 'Profile Management'
        ]);
    }

    public function payment()
    {
        return view('user.dashboard.studio.studio_payment', [
            'pageTitle' => 'Profile Management'
        ]);
    }

    public function security()
    {
        return view('user.dashboard.studio.studio_security', [
            'pageTitle' => 'Profile Management'
        ]);
    }
}
