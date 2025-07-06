<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;
use Hash;
use Str;
use App\Models\User;

class AuthController extends BaseController
{
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:5'],


        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors()->first());
        }


        try {
            $input = $request->except(['password'],$request->all());
            $input["password"] = Hash::make($request->password);

            User::create($input);
            return $this->sendResponse($data =[],"User Register Successfully");


        } catch (\Throwable $th) {
            return $this->sendError("Something Went Wrong");
        }


    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        try {
            $credentials = [
                'email' => $request->email,
                "password"=>$request->password
            ];
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $user->update([
                    'last_login_at' => now(), // Assuming 'last_login_at' is a timestamp/datetime field
                    'last_login_ip' => request()->ip(), // Get the user's IP address
                ]);
                $success['token'] = $user->createToken('Guestly')->accessToken;
                $success['name'] = Str::upper($user->name);
                // $success['user'] = $user;

                return $this->sendResponse($success, 'User login successfully.');
            } else {
                return $this->sendError('Invalid credentials. Please check your email or password.');
            }
        } catch (\Illuminate\Auth\AuthenticationException $e) {
            return $this->sendError($e->getMessage());
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }
    }

    public function VerifyEmail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }

            $emailExists = User::where('email', $request->email)->first();
            if (isset($emailExists)) {
                $otp = rand(1000, 9999);
                $data['otp']=$otp;
                $emailExists->update([
                    'otp'=>$otp
                ]);
                sendVerificationMail($otp,$request->email);
                return $this->sendResponse($data, 'Code Send Successfully');

            } else {
                return $this->sendError('Invalid Email Address');
            }

        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }
    }

    public function VerifyEmailCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        try {
            $emailExists = User::where('email', $request->email)->where('otp',$request->code)->first();

            if ($emailExists) {
                return $this->sendResponse([], 'Code Verified Successfully');
            } else {
                return $this->sendError('Invalid Code');
            }

        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }
    }

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',

        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors()->first());
        }
        try {
            # code...
            $user = null;
            $input["password"] = Hash::make($request->password);
            if ($request->email) {
                $user = User::where('email', $request->email)->first();
                if (!isset($user)) {
                    return $this->sendError('Invalid Email');
                }
                $user->update($input);
                return $this->sendResponse($data =[],"Password Changed Successfully");
            }else {
                return $this->sendError('Something went wrong');
            }
        } catch (\Throwable $e) {
            return $this->sendError('Something went wrong');
        }

    }


     public function googleLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required'],
            'google_id' => ['required'],

        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors()->first());
        }
        try {

            $data = $request->except(['name','google_id'],$request->all());
            $data['name'] = $request->name;
            $data['password'] = hash::make($request->google_id);
            $data['google_id'] = $request->google_id;


            $checkEmail = User::where('email',$request->email)->first();
            if($checkEmail)
            {
                $checkEmail->update($data);
                $checkEmail = User::where('email',$request->email)->first();
                if (Auth::attempt(['email' => $request->email, 'password' =>  $request->google_id])) {
                    $user = Auth::user();

                    $success['token'] =  $user->createToken('Guestly')->accessToken;
                    $success['name'] =  Str::upper($user->name);
                    $success['user'] = $user;
                    return $this->sendResponse($success, 'User login successfully.');

                }else{
                    return $this->sendError('SomeThing went wrong please try agian');

                }

            }else{
                $input['email'] = $request->email;
                $input['name'] =    $data['name'];
                $input['password'] = Hash::make($request->google_id);
                $input['google_id'] = $request->google_id;
                $user = User::create($input);
                $success['token'] =  $user->createToken('Guestly')->accessToken;
                $success['name'] =  Str::upper($user->name);
                return $this->sendResponse($success, 'User login successfully.');

            }
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }
    }
}
