<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoForbiddenWords implements Rule
{
    protected $forbiddenWords = ['spam', 'forbidden', 'bad'];

    public function passes($attribute, $value)
    {
        $words = explode(' ', strtolower($value));
        return !array_intersect($words, $this->forbiddenWords);
    }

    public function message()
    {
        return 'The :attribute contains forbidden words.';
    }
}