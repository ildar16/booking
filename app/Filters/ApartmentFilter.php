<?php

namespace App\Filters;


use Illuminate\Support\Facades\DB;

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

    public function username($value)
    {
        $this->builder->whereHas('user', function ($query) use ($value) {
            $query->where('name', $value);
        });
    }

    public function orderBy($value)
    {
        $sql = $this->builder;
        $param = "";

        if (strstr($value, '-')) {
            $param = "DESC";
        } else {
            $param = "ASC";
        }

        $value = str_replace("-", "", $value);

        if ($value == "allBooks") {
            $this->builder->withCount('book')->orderBy('book_count', $param);
        } elseif ($value == "actualBooks") {
            $sql->withCount(['book' => function ($query) {
                $query->where('book_end', '>', date('Y-m-d'));
            }])->orderBy('book_count', $param);
        } else {
            $this->builder->orderBy($value, $param);
        }

    }

}