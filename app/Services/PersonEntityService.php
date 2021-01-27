<?php

namespace App\Services;

use App\Models\Person;
use App\Rules\BirthDayRule;

use App\Interfaces\Services\iPersonEntityService;

class PersonEntityService extends BaseEntityService implements iPersonEntityService {

    protected Person $person;

    public function __construct(Person $person)
    {
        parent::__construct($person);
    }

    public static function checkBirthDayDate(string $date): bool {
        $rule = new BirthDayRule();
        return $rule->passes($date);
    }

    public static function convertBirthDayToDays(string $date): int {
        return round((time() - strtotime($date)) / (60 * 60 * 24));
    }
}