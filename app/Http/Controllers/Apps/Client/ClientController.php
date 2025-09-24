<?php

namespace App\Http\Controllers\Apps\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\CustomForm;
use App\Models\ClientBookingForm;
use App\Models\ClientBookingFormResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Hash;
use Validator;
class ClientController extends Controller
{
    public function index($artist_id,$artist_name,$shared_code,$booking_id = null)
    {
         
        $artist = User::where('user_type', 'artist')->where('name', $artist_name)->where('id', $artist_id)->first();
        if(empty($artist)){
            dd('artist not found');
        }
        
        $data = ClientBookingForm::
        where('shared_code', $shared_code)
        ->where('artist_id', $artist_id)
        ->with(['customForm.fields','studio'])
        ->first();


        if (empty($data)) {
            dd('client booking form not found');
        }

        
        return view('user.pages.client.custom_form',compact('data'));
    }

    public function submitForm(Request $request, $shared_code)
    {

        // Find booking using shared_code
        $booking = ClientBookingForm::where('shared_code', $request->shared_code)->firstOrFail();
        $userEmail = '';
        $name = '';
        $lastName = '';
        $password = Hash::make('haseeb@123');
        // Update booking status
        $booking->status = 'pending';
        $booking->save();
        $user = null;
        foreach ($request->except(['_token', 'shared_code', 'studio_name', 'booking_date', 'booking_time']) as $key => $value) {
            // Split the field name and field ID
            [$fieldName, $fieldId] = explode('|', $key);
            if ($fieldName == 'email') {
                $userEmail = $value;
            }
            if ($fieldName == 'full_name' || $fieldName == 'name' || $fieldName == 'first_name' ) {
                $name = $value;
            }

            if($fieldName == 'last_name'  ) {
                $lastName = $value;
            }
            // If multi-select, store as JSON
            if (is_array($value)) {
                $value = json_encode($value);
            }

            // Save response
            ClientBookingFormResponse::updateOrCreate(
                [
                    'client_booking_form_id' => $booking->id,
                    'custom_form_field_id' => $fieldId
                ],
                ['value' => $value]
            );
            
            if ($userEmail) {
                 
                $user = User::where('email', $userEmail)->first();

                if (!$user) {
                    // Create new user if not exists
                    $user = User::create([
                        'name'     => $name??'',
                        'last_name' => $lastName??'',
                        'email'    => $userEmail??'',
                        'user_type' => 'user',
                        'role_id' => 'user',
                        'password' => $password,
                        'profile_link' => Str::uuid()
                    ]);
                }
                

                // ✅ Assign role "user" if not already assigned
                if (!$user->hasRole('user')) {
                    $user->assignRole('user');
                }
                $booking->update([
                    'client_id' => $user->id
                ]);
            }
            
        }
        $profileUrl = route('client.profile', ['token' => $user->profile_link, 'shared_code' => $request->shared_code]);
        sendBookingMail($user->name,$user->last_name, $user->email,$profileUrl );
         
        return redirect()->route('client.done'); 
    }

    public function thankyouPage(Request $request)
    {
        return view('user.pages.client.thank_you');
         
    }

    public function profile($shared_code, $token)
    {
        // $user = User::where('profile_link', $token)->first();
        $user = User::first();
        if (empty($user)) {
            dd('user not found');
        }
        $booking =ClientBookingForm::with([
            'studio',
            'artist',
            'client',
            'booking',
            'responses.field', // load fields
        ])->whereIn('status', ['approve'])->first();
        //  dd($booking);
        if (empty($booking)) {
            dd('user not found');
        }
        // Fetch bookings if needed
        // dd($booking);
        // $bookings = $user->bookings ?? [];
        $bookings = $booking ?? [];
        $messages = [];
        // dd($booking);
        return view('user.pages.client.profile', compact('user', 'bookings','booking','messages'));
    }
}
