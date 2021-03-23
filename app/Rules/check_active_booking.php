<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Booking;

class check_active_booking implements Rule
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
       
        $result = Booking::where('status','!=','cancelled')->where('status','!=','done')->where('user_id', $value)->first();
      
        return !isset($result);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Cannot book, you currently have an active booking.';
    }
}
