<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
		'client_booking_form_id',
		'client_id',
		'artist_id',
		'amount',
		'currency',
		'type',
		'status',
		'stripe_payment_intent_id',
		'stripe_charge_id',
		'stripe_transfer_id',
		'transferred_at',
		'billing_details',
		'shipping',
	];

    protected $casts = [
		'billing_details' => 'array',
		'shipping' => 'array',
		'transferred_at' => 'datetime',
	];

    public function booking() { return $this->belongsTo(ClientBookingForm::class, 'client_booking_form_id'); }
}
