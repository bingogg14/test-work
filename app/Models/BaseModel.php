<?php

namespace App\Models;

use App\Interfaces\Models\iBaseModel;

abstract class BaseModel implements iBaseModel {

    protected $id;
    protected $statusError;
    protected $errorMessages;

    public function __construct()
    {
        $this->id = 0;
        $this->statusError = false;
        $this->errorMessages = [];
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getStatusError(): bool {
        return $this->statusError;
    }

    public function getErrorMessages(): array {
        return $this->errorMessages;
    }

    // Setters
    public function setId(int $id): void {
        $this->id = $id;
    }

    protected function setStatusError(bool $status): void {
        $this->statusError = $status;
    }

    protected function setErrorMessages($messages): void {

        $this->setStatusError(true);
        //Перед добавлением ошибок, очищаем массив пред.ошибок
        $this->clearErrorMessages();

        if (is_string($messages)) {
            $this->addErrorMessage($messages);
        } else if (is_array($messages)) {
            foreach ($messages as $message) {
                if (is_string($message)) {
                    $this->addErrorMessage($message);
                }
            }
        }
    }

    // Helpers
    protected function addErrorMessage(string $messages): void {
        $this->errorMessages[] = $messages;
    }

    protected function clearErrorMessages(): void {
        $this->errorMessages = [];
    }


    // Save
    public function save()
    {
        //Todo before first save need set unique id
    }
}