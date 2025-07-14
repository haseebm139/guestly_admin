<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\StudioExists;
class StoreSpotBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'studio_id'         => ['required', new StudioExists],
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date',
            'is_tour_requested' => 'boolean',
            'booking_type'      => 'required|in:solo,group',
            'group_artists'     => 'nullable|array',
            'message'           => 'nullable|string',

            'portfolio_files'     => 'nullable|array|max:5',
            'portfolio_files.*'   => 'file|mimes:jpg,jpeg,png', // max 2MB each
        ];

    }


    public function messages(): array
    {
        return [
            'studio_id.required'         => 'Studio is required.',
            'studio_id.exists'           => 'The selected studio does not exist.',
            'start_date.required'        => 'Start date is required.',
            'start_date.date'            => 'Start date must be a valid date.',
            'end_date.required'          => 'End date is required.',
            'end_date.date'              => 'End date must be a valid date.',
            'end_date.after_or_equal'    => 'End date must be the same or after the start date.',
            'is_tour_requested.boolean'  => 'Tour request must be true or false.',
            'booking_type.required'      => 'Booking type is required.',
            'booking_type.in'            => 'Booking type must be either solo or group.',
            'group_artists.array'        => 'Group artists must be a list of user IDs.',
            'message.string'             => 'Message must be a text value.',

            'portfolio_files.array' => 'Portfolio files must be an array.',
            'portfolio_files.max' => 'You can upload a maximum of 5 portfolio files.',
            'portfolio_files.*.file' => 'Each portfolio item must be a valid file.',
            'portfolio_files.*.mimes' => 'Portfolio files must be JPG, PNG.',
            'portfolio_files.*.max' => 'Each file must not exceed 2MB.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {


        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),

            ], 422)
        );
    }
}
