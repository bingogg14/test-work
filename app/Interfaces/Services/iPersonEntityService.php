<?php

namespace App\Interfaces\Services;

interface iPersonEntityService
{
    public static function checkBirthDayDate(string $date);
    public static function convertBirthDayToDays(string $date);
}