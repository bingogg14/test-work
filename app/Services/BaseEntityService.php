<?php

namespace App\Services;

abstract class BaseEntityService {

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
}