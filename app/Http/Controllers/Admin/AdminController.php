<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $u_rep;
    protected $a_rep;
    protected $c_rep;
    protected $b_rep;

    protected $title;

    protected $vars = [];

    protected $template;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');

        $this->template = config('settings.theme') . '.admin.index';
    }

    protected function renderOutput()
    {
        $this->vars = array_add($this->vars,'title',$this->title);
        $footer = view(config('settings.theme').'.admin.footer')->render();
        $this->vars = array_add($this->vars,'footer',$footer);

        return view($this->template)->with($this->vars);
    }
}
