<?php

namespace App\Repositories;

use App\Comfort;

class ComfortRepository
{

    public function __construct(Comfort $comfort)
    {
        $this->model = $comfort;
    }

}