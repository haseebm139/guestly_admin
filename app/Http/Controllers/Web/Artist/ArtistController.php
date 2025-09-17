<?php

namespace App\Http\Controllers\Web\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function explore()
    {
        return view('user.dashboard.artist.explore', [
            'pageTitle' => 'Explore'
        ]);
    }

    public function studioDetail()
    {
        return view('user.dashboard.artist.studio_detail', [
            'pageTitle' => 'Explore'
        ]);
    }

    public function chat()
    {
        return view('user.dashboard.artist.artist_chat', [
            'pageTitle' => 'Messages'
        ]);
    }

    public function profile()
    {
        return view('user.dashboard.artist.artist_profile', [
            'pageTitle' => 'Profile Management'
        ]);
    }

    public function security()
    {
        return view('user.dashboard.artist.artist_security', [
            'pageTitle' => 'Profile Management'
        ]);
    }

    public function bio()
    {
        return view('user.dashboard.artist.artist_bio', [
            'pageTitle' => 'Profile Management'
        ]);
    }

    public function subscription()
    {
        return view('user.dashboard.artist.artist_subscription', [
            'pageTitle' => 'Profile Management'
        ]);
    }

    public function rating()
    {
        return view('user.dashboard.artist.artist_rating', [
            'pageTitle' => 'Profile Management'
        ]);
    }

    public function payment()
    {
        return view('user.dashboard.artist.artist_payment', [
            'pageTitle' => 'Profile Management'
        ]);
    }

    public function booking()
    {
        return view('user.dashboard.artist.artist_booking', [
            'pageTitle' => 'Bookings'
        ]);
    }

    public function guestSpot()
    {
        return view('user.dashboard.artist.artist_guest_spot', [
            'pageTitle' => 'Bookings'
        ]);
    }

    public function request()
    {
        return view('user.dashboard.artist.artist_request', [
            'pageTitle' => 'Requests'
        ]);
    }

    public function tattoo()
    {
        return view('user.dashboard.artist.artist_tattoo', [
            'pageTitle' => 'Flash Tattoos'
        ]);
    }
}
