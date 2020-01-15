<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class BorrowBookRule implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //value, chuyen tu pay_day sang carbon
        $payDate = Carbon::parse($value);
        $now = Carbon::now();
        //so sanh giua ngay hien tai va ngay tra diffInDays
        if ($now->diffInDays($payDate) <= 3 && $now <= $payDate) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Ở đây chúng tôi không làm thế:))), bạn chỉ được mượn 4 ngày thôi nhes';
    }
}
