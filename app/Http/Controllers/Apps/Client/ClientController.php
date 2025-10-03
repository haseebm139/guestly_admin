<?php

namespace App\Http\Controllers\Apps\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientBookingForm;
use App\Models\ClientBookingFormResponse;
use App\Models\Payment;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stripe\Stripe;

class ClientController extends Controller
{
    public function index($artist_id, $artist_name, $shared_code, $booking_id = null)
    {

        $artist = User::where('user_type', 'artist')->where('name', $artist_name)->where('id', $artist_id)->first();
        if (empty($artist)) {
            dd('artist not found');
        }

        $data = ClientBookingForm::where('shared_code', $shared_code)
            ->where('artist_id', $artist_id)
            ->with(['customForm.fields', 'studio'])
            ->first();

        if (empty($data)) {
            dd('client booking form not found');
        }

        return view('user.pages.client.custom_form', compact('data'));
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
            // Split the field name, field ID, and field type
            $parts = explode('|', $key);
            $fieldName = $parts[0] ?? '';
            $fieldId = $parts[1] ?? '';
            $fieldType = $parts[2] ?? 'text';
            
            // Handle different field types
            if ($fieldType === 'image') {
                // Handle image uploads - use the key with [] for file uploads
                $fileKey = $key . '[]';
                $value = $this->processImageUploads($request, $fileKey);
                 
            } else {
                // Handle other field types
                if ($fieldName == 'email') {
                    $userEmail = $value;
                }
                if ($fieldName == 'full_name' || $fieldName == 'name' || $fieldName == 'first_name') {
                    $name = $value;
                }
                if ($fieldName == 'last_name') {
                    $lastName = $value;
                }
                
                // If multi-select, store as JSON
                if (is_array($value)) {
                    $value = json_encode($value);
                }
            }

            // Save response
            ClientBookingFormResponse::updateOrCreate(
                [
                    'client_booking_form_id' => $booking->id,
                    'custom_form_field_id' => $fieldId,
                ],
                ['value' => $value]
            );

            if ($userEmail) {
                $user = User::where('email', $userEmail)->first();

                if (!$user) {
                    // Create new user if not exists
                    $user = User::create([
                        'name' => $name ?? '',
                        'last_name' => $lastName ?? '',
                        'email' => $userEmail ?? '',
                        'user_type' => 'user',
                        'role_id' => 'user',
                        'password' => $password,
                        'profile_link' => Str::uuid(),
                    ]);
                }

                // ✅ Assign role "user" if not already assigned
                if (!$user->hasRole('user')) {
                    $user->assignRole('user');
                }
                if ($user->profile_link == null) {
                    $user->update([
                        'profile_link' => Str::uuid(),
                    ]);
                }
                $booking->update([
                    'client_id' => $user->id,
                ]);
            }
        }
        
        $profileUrl = route('client.profile', ['shared_code' => $request->shared_code, 'token' => $user->profile_link]);
        sendBookingMail($user->name, $user->last_name, $user->email, $profileUrl);

        return redirect()->route('client.done');
    }

    public function thankyouPage(Request $request)
    {
        return view('user.pages.client.thank_you');

    }

    public function profile($sharedCode, $token)
    {
        $user = User::where('profile_link', $token)->first();

        if (! $user) {
            abort(404, 'User not found');
        }

        $booking = ClientBookingForm::with([
            'studio',
            'artist',
            'client',
            'booking',
            'payment',
            'responses.field', // load fields
        ])
            // ->where('status', ['approve', 'approved_pending_payment','pending'])
            ->where('shared_code', $sharedCode)
            ->first();

        if (! $booking) {
            abort(404, 'Booking not found');
        }

        $bookings = $booking;
        $messages = [];
         
        return view('user.pages.client.profile', compact('user', 'bookings', 'booking', 'messages'));
    }

    public function createPaymentIntent(Request $request, $id)
    {
        $booking = ClientBookingForm::findOrFail($id);
        if (! $booking->deposit) {
            return response()->json(['error' => 'No deposit set for this booking'], 400);
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $amountInCents = (int) round($booking->deposit * 100);
        $clientEmail = $booking->client->email ?? '';

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amountInCents,
            'currency' => 'usd',
            'description' => "Tattoo service deposit - Booking #{$booking->id}",
            'receipt_email' => $clientEmail ?: null,
            'transfer_group' => 'booking_'.$booking->id,
            'automatic_payment_methods' => ['enabled' => true], // Payment Element
            'metadata' => [
                'booking_id' => (string) $booking->id,
                'customer_email' => $clientEmail,
                'type' => 'deposit',
            ],
        ]);

        return response()->json(['client_secret' => $paymentIntent->client_secret]);
    }

    public function payDeposit(Request $request, $id)
    {
        $request->validate(['payment_intent_id' => 'required|string']);
        $booking = ClientBookingForm::findOrFail($id);

        Stripe::setApiKey(config('services.stripe.secret'));

        // Retrieve PI with latest_charge expanded to easily capture the Charge ID
        $pi = \Stripe\PaymentIntent::retrieve([
            'id' => $request->payment_intent_id,
            'expand' => ['latest_charge'],
        ]);

        if (($pi->metadata->booking_id ?? null) !== (string) $booking->id) {
            return response()->json(['error' => 'Payment does not match booking'], 400);
        }

        if ($pi->status !== 'succeeded') {
            return response()->json(['error' => 'Payment not completed', 'status' => $pi->status], 400);
        }

        $chargeId = $pi->latest_charge?->id;

        // Persist the deposit payment
        $payment = Payment::create([
            'client_booking_form_id' => $booking->id,
            'client_id' => $booking->client_id,
            'artist_id' => $booking->artist_id,
            'amount' => $pi->amount_received, // cents
            'currency' => $pi->currency,
            'type' => 'deposit',
            'status' => 'succeeded',
            'stripe_payment_intent_id' => $pi->id,
            'stripe_charge_id' => $chargeId,
            'billing_details' => [
                'name' => $pi->charges->data[0]->billing_details->name ?? null,
                'email' => $pi->charges->data[0]->billing_details->email ?? null,
                'address' => $pi->charges->data[0]->billing_details->address ?? null,
            ],
            'shipping' => $pi->shipping ? [
                'name' => $pi->shipping->name,
                'address' => $pi->shipping->address,
            ] : null,
        ]);

        // Mark booking approved
        $booking->update(['status' => 'approve']);

        return response()->json([
            'success' => true,
            'message' => 'Deposit saved',
            'booking' => $booking,
            'payment_id' => $payment->id,
        ]);
    }

    public function imageUpload(Request $request)
    {
        
        $validator = \Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $file = $request->file('image');
        $filename = 'chat-images-'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('chat_images/clients'), $filename);
         
        $path = 'chat_images/clients'.'/'.$filename;

        return response()->json([
            'success' => true,
            'url' => asset($path),
            'path' => $path,
            'message' => 'Image uploaded successfully.',
        ]);
    }

    /**
     * Process image uploads for form fields
     */
    private function processImageUploads(Request $request, $key)
    {
        // Try the key as-is first, then with [] suffix
        $fileKey = $key;
        if (!$request->hasFile($key)) {
            // Remove [] from the end and try again
            $fileKey = rtrim($key, '[]');
            if (!$request->hasFile($fileKey)) {
                \Log::warning('File not found for either key: ' . $key . ' or ' . $fileKey);
                return json_encode([]);
            }
        }
          
        $uploadedImages = $request->file($fileKey);
         
        if (!is_array($uploadedImages)) {
            $uploadedImages = [$uploadedImages];
        }

        $imagePaths = [];
        
        // Create directory if it doesn't exist
        $uploadPath = public_path('uploads/client-images');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        foreach ($uploadedImages as $image) {
             
            if (!$image->isValid()) {
                continue;
            }
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($image->getMimeType(), $allowedTypes)) {
                continue;
            }
            
            // Validate file size (5MB max)
            if ($image->getSize() > 5 * 1024 * 1024) {
                continue;
            }
            
            try {
                // Get file properties BEFORE moving the file
                $originalName = $image->getClientOriginalName();
                $fileSize = $image->getSize();
                $mimeType = $image->getMimeType();
                
                // Generate unique filename
                $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                
                // Store image
                $image->move($uploadPath, $filename);
                $path = 'uploads/client-images/' . $filename;
                
                $imageData = [
                    'path' => $path,
                    'original_name' => $originalName,
                    'size' => $fileSize,
                    'mime_type' => $mimeType,
                    'uploaded_at' => now()->toISOString()
                ];
                
                $imagePaths[] = $imageData;
                
            } catch (\Exception $e) {
                \Log::error('Failed to upload image: ' . $e->getMessage());
                continue;
            }
        }
        return json_encode($imagePaths);
    }
}
