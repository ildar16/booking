<?php

namespace App\Filters;


class ApartmentFilter extends AbstractFilter
{

//    public function category_id($value)
//    {
//        $this->builder->where('category_id', $value);
//    }

    public function square($value)
    {

        $this->builder->where('square', '>=', $value[0]);
        $this->builder->where('square', '<=', $value[1]);
    }

    public function rooms($value)
    {
        $this->builder->whereIn('rooms', $value);
    }

    public function price($value)
    {
        $price = explode(",", $value);
        $this->builder->where('price', '>=', $price[0]);
        $this->builder->where('price', '<=', $price[1]);
    }

}