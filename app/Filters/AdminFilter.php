<?php

namespace App\Filters;


class AdminFilter extends AbstractFilter
{

    public function username($value)
    {
        $this->builder->whereIn('rooms', $value);
    }

}