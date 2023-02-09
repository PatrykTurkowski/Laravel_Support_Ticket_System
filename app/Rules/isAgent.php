<?php

namespace App\Rules;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class isAgent implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return User::find($value)->role === RoleEnum::AGENT->value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('This user is not a Agent!');
    }
}