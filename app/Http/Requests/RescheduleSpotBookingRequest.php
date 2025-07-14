<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\StudioExists;
class RescheduleSpotBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
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
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date',
            'reschedule_note'          => 'required',
            'rescheduled_by'          => 'required|in:artist,studio',
        ];
    }

    public function messages(): array
    {
        return [

            'start_date.required'        => 'Start date is required.',
            'start_date.date'            => 'Start date must be a valid date.',
            'end_date.required'          => 'End date is required.',
            'end_date.date'              => 'End date must be a valid date.',
            'end_date.after_or_equal'    => 'End date must be the same or after the start date.',
            'reschedule_note.required'    =>'Reason by is required.',
            'rescheduled_by.required'    => 'Rescheduled by is required.',
            'rescheduled_by.in'          => 'Rescheduled by must be either artist or studio.',



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
