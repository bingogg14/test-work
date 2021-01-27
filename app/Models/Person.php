<?php

namespace App\Models;

use App\Controllers\MankindController;
use App\Services\PersonEntityService;

class Person extends BaseModel
{

    public const FEMALE = [
      'key' => 'F',
      'bool' => 0
    ];
    public const MALE = [
      'key' => 'M',
      'bool' => 1
    ];
    public const FIELDS = [
      'id' => 0,
      'name' => 1,
      'surname' => 2,
      'sex' => 3,
      'birthDay' => 4
    ];

    protected string $name;
    protected string $surname;
    protected bool $sex;
    protected string $birthDay; // YYYY.MM.DD

    public function __construct(string $name, string $surname, bool $sex, string $birthDay)
    {
        parent::__construct();
        $this->setName($name);
        $this->setSurname($surname);
        $this->setSex($sex);
        $this->setBirthDate($birthDay);
    }

    // Getters
    public function getName(): string {
        return $this->name;
    }

    public function getSurname(): string {
        return $this->surname;
    }

    public function getSex(): string {
       return $this->sex === (bool)self::FEMALE['bool'] ? self::FEMALE['key'] : self::MALE['key'];
    }

    public function getBirthDate(): string {
        return $this->birthDay;
    }

    // Setters
    private function setName(string $name): void {
        $this->name = $name;
    }

    private function setSurname(string $surname): void {
        $this->surname = $surname;
    }

    private function setSex(bool $sex): void {
        $this->sex = $sex;
    }

    private function setBirthDate(string $birthDate): void {
        if (PersonEntityService::checkBirthDayDate($birthDate)) {
            $this->birthDay = $birthDate;
        } else {
            $this->birthDay = ''; //Default date empty
            $this->setErrorMessages('Неправильно задан формат даты YYYY-MM-DD');
        }
    }

    // Custom Attributes
    public function getAgeInDaysAttribute() {
        if (!empty($this->birthDay)) {
            return PersonEntityService::convertBirthDayToDays($this->birthDay);
        }

        $this->setErrorMessages('Неправильно задан формат даты YYYY-MM-DD, невозможно вернуть кол-во дней от даты');
        return '';
    }

    // Save
    public function save(): bool {
        $mankind = MankindController::getInstance();
        return $mankind->addNewPerson($this);
    }
}