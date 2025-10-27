<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


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

    public function choosePlan(Request $request)
{

    $role_type = auth()->user()->user_type ?? 'user';

    $plans = Plan::where('user_type', $role_type)
        ->with('features')
        ->get();

    return view('user.common.choose_plan', compact('plans', 'role_type'));
}


    public function studioChoosePlan()
    {
        return view('user.common.studio_choose_plan');
    }

    public function userIdentification()
    {
        $user = Auth::user();
        return view('user.common.user_identification', ['user' => $user]);
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

    public function forgotPasswordSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email not found in our records.']);
        }

        // Generate 4 digit OTP
        $otp = rand(1000, 9999);

        // Save OTP in user table
        $user->otp = $otp;
        $user->save();
        session(['email' => $request->email]);

        // Redirect to verify otp page
        $role = $user->role_id??'artist';

        // Redirect to verify_otp page with role param
        return redirect()->to(route('verify_otp', ['role' => $role]))
            ->with(['email' => $user->email]);
    }

    public function verifyOtpSubmit(Request $request)
    {
        $otp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4;

        $request->merge(['otp' => $otp]);

        $request->validate([
            'otp' => 'required|digits:4',
        ]);
        session(['email' => $request->email]);

        $user = User::where('otp', $otp)->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'Invalid OTP, please try again.']);
        }

        return redirect()->route('reset_password', ['role' => $request->role])
            ->with('success', 'OTP verified successfully!');
    }

    public function resetPasswordSubmit(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.confirmed' => 'Password and Confirm Password must match.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);


        $email = session('email');

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->otp = null;
            $user->save();

            return redirect()->route('form_login_signup', ['role' => $request->role ?? 'artist'])
                ->with('success', 'Password updated successfully, please login.');
        }

        return back()->withErrors(['password' => 'Something went wrong, please try again.']);
    }

    public function resendOtp(Request $request)
    {
        $email = $request->email ?? session('email');

        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please go back and try again.'
            ]);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ]);
        }

        $otp = rand(1000, 9999);
        $user->otp = $otp;
        $user->save();

        // Mail::to($user->email)->send(new \App\Mail\SendOtpMail($otp));

        return response()->json([
            'success' => true,
            'message' => 'A new OTP has been sent to your email.'
        ]);
    }

    public function verifyDocuments(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'front_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'back_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Back image optional hai
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not authenticated.'], 401);
        }

        if ($request->hasFile('front_image')) {
            if ($user->document_front) { Storage::disk('public')->delete($user->document_front); }
            $path = $request->file('front_image')->store('user_documents', 'public');
            $user->document_front = $path;
        }

        if ($request->hasFile('back_image')) {
            if ($user->document_back) { Storage::disk('public')->delete($user->document_back); }
            $path = $request->file('back_image')->store('user_documents', 'public');
            $user->document_back = $path;
        }

        $user->verification_status = '2';
        $user->otp = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Documents uploaded and verified successfully!',
            'redirect_url' => route('dashboard.explore') // Dashboard ka route
        ]);
    }


    /**
     * OTP generate karke database mein save karne ke liye.
     */
    public function generateOtp(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not authenticated.']);
        }

        $otp = rand(1000, 9999);

        $user->otp = $otp;
        $user->save();

        // For example, using Laravel Mail:
        // if ($request->type === 'email') {
        //     \Mail::to($user->email)->send(new YourOtpMail($otp));
        // } else {
        //     // SMS gateway
        // }

        return response()->json([
            'success' => true,
            'message' => 'OTP generated and sent successfully.'
        ]);
    }

    public function authVerifyOtpSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|string|min:4|max:4',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $user = Auth::user();

        if ($user && $user->otp == $request->otp) {

            $user->verification_status = '2';
            $user->otp = null;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully! Redirecting...',
                'redirect_url' => route('dashboard.explore')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'The OTP you entered is incorrect. Please try again.'
        ], 400);
    }

    public function authResendOtp(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        $otp = rand(1000, 9999);
        $user->otp = $otp;
        $user->save();

        // try {
        //     Mail::to($user->email)->send(new \App\Mail\SendOtpMail($otp));
        // } catch (\Exception $e) {
        //     // Optional: email fail
        // }

        return response()->json([
            'success' => true,
            'message' => 'A new OTP has been sent to you.'
        ]);
    }

    public function authVerifyPhone(Request $request)
    {
        $validator = Validator::make($request->all(), ['phone' => 'required|string|min:10']);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $user = Auth::user();
        $user->phone = $request->phone;
//        $user->phone_verified_at = now();
        $user->verification_status = '2';
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Phone number verified successfully!',
            'redirect_url' => route('dashboard.explore')
        ]);
    }
}
