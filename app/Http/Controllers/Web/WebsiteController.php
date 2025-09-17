<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function formSlider()
    {
        
        return view('user.common.form_slider');
    }

    public function formSliderTwo()
    {
        return view('user.common.form_slider_two');
    }

    public function formLoginSignup()
    {
        return view('user.common.form_login_signup');
    }

    public function choosePlan()
    {
        return view('user.common.choose_plan');
    }

    public function studioChoosePlan()
    {
        return view('user.common.studio_choose_plan');
    }

    public function userIdentification()
    {
        return view('user.common.user_identification');
    }

    public function docVerification()
    {
        return view('user.common.doc_verification');
    }

    public function phoneEmailVerification()
    {
        return view('user.common.phone_email_verification');
    }

    public function studioStepForm()
    {
        return view('user.common.studio_step_form');
    }

    public function boostStudio()
    {
        return view('user.common.boost_studio');
    }

    public function forgotPassword()
    {
        return view('user.common.forgot_password');
    }

    public function resetPassword()
    {
        return view('user.common.reset_password');
    }

    public function verifyOtp()
    {
        return view('user.common.verify_otp');
    }
}
