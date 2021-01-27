<?php

namespace App\Rules;

use App\Interfaces\iRule;

final class BirthDayRule implements iRule {

    public function passes($value): bool
    {
        // YYYY.MM.DD
        return (bool)preg_match("/^[0-9]{4}.(0[1-9]|1[0-2]).(0[1-9]|[1-2][0-9]|3[0-1])$/",$value);
    }
}