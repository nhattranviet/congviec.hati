<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NhankhauRule implements Rule
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
        // $count_val = array_count_values($value);
       return ($value == 1) ? TRUE : FALSE;
            
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Bạn phải chọn 01 chủ hộ';
    }
}
