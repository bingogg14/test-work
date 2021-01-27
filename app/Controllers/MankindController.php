<?php

namespace App\Controllers;

use App\Models\Person;
use Iterator;

final class MankindController implements Iterator {

    private static ?MankindController $instance = null;

    private array $dataIds;
    private array $data;
    private int $countSexMan;

    public function __construct() {

        $this->dataIds = [];
        $this->getDataForFile();

    }

    public static function getInstance(): MankindController
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    //Работает только в случае, если мы не удаляем старые строки
    public function findById(int $id): ?Person {
        $data = $this->data[$id - 1] ?? null;
        if (is_array($data)) {
            $person = new Person($data[Person::FIELDS['name']], $data[Person::FIELDS['surname']], $data[Person::FIELDS['sex']], $data[Person::FIELDS['birthDay']]);
            $person->setId($data[Person::FIELDS['id']]);
            return $person;
        }

        return null;
    }

    public function getPercentageOfMan(): float {
        //Get Again data
        $this->getDataForFile();

        if ($this->countSexMan !== 0) {
            $fileController = FileController::getInstance();
            var_dump($fileController->getCountRows());
            var_dump($this->countSexMan);
            return get_percentage($fileController->getCountRows(), $this->countSexMan);
        }

        return 0;
    }

    public function addNewPerson(Person $person): bool {
        $fileController = FileController::getInstance();
        $person->setId($fileController->getCountRows() + 1);
        return $fileController->appendRow([
          $person->getId(),
          $person->getName(),
          $person->getSurname(),
          $person->getSex(),
          $person->getBirthDate(),
        ]);
    }

    // Iterator
    public function current()
    {
        return current($this->dataIds);
    }

    public function next()
    {
        return next($this->dataIds);
    }

    public function key()
    {
        return key($this->dataIds);
    }

    public function valid()
    {
        $key = key($this->dataIds);
        return ($key !== NULL && $key !== FALSE);
    }

    public function rewind(): void
    {
        reset($this->dataIds);
    }

    private function getDataForFile(): void {
        $this->clearData();
        $fileController = FileController::getInstance();
        $this->data = $fileController->getData();

        if (!empty($this->data)) {
            foreach ($this->data as $value) {
                $this->dataIds[] = $value[Person::FIELDS['id']];
                if ($value[Person::FIELDS['sex']] === Person::MALE['key']) {
                    $this->countSexMan++;
                }
            }
        }
    }

    private function clearData(): void {
        $this->data = [];
        $this->dataIds = [];
        $this->countSexMan = 0;
    }
}