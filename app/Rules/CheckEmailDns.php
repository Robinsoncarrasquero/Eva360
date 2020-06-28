<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;

class CheckEmailDns implements Rule
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
        //
        return (new EmailValidator())->isValid($value, new DNSCheckValidation());

    }



    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return \trans('validation.check_email_dns');

    }
}
