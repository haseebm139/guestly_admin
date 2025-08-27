<?php

namespace App\Http\Controllers\Apps\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\CustomForm;
use App\Models\ClientBookingForm;
use App\Models\ClientBookingFormResponse;

use Hash;
use Validator;
class ClientController extends Controller
{
    public function index($artist_id,$artist_name,$shared_code)
    {

        $artist = User::where('user_type', 'artist')->where('name', $artist_name)->where('id', $artist_id)->first();
        if(empty($artist)){
            dd('artist not found');
        }
        // dd($artist);
        $data = ClientBookingForm::
        where('shared_code', $shared_code)
        ->where('artist_id', $artist_id)
        ->with(['customForm.fields','studio'])
        ->first();


        if (empty($data)) {
            dd('client booking form not found');
        }

        // echo "<pre>";
        // print_r(json_encode($form));
        // exit;
        //  dd($clientForm->fields);
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
        $booking->status = 'submitted';
        $booking->save();
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
            $user = null;
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
                        'password' => $password
                    ]);
                }

                // ✅ Assign role "user" if not already assigned
                if (!$user->hasRole('user')) {
                    $user->assignRole('user');
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Form submitted successfully.'
        ]);
    }
}
