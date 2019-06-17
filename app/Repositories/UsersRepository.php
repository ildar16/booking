<?php

namespace App\Repositories;

use App\User;

class UsersRepository extends Repository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function one($id, $attr = array(), $where = false)
    {
        $user = $this->model->where('id', $id)->first();

        return $user;
//        return parent::one($alias, $attr, $where);
    }

}