<?php

namespace App\Interfaces\Models;

interface iBaseModel
{
    public function getId();
    public function getStatusError();
    public function getErrorMessages();
    public function save();
}