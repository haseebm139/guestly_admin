<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\User;

class StudioExists implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $studio = User::where('id', $value)
            ->where('user_type', 'studio') // or 'role' if that's your column
            ->first();

        if (! $studio) {
            $fail('The selected studio ID is invalid or the user is not a studio.');
        }
    }
}
