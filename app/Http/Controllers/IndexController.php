<?php

namespace App\Http\Controllers;

use App\Repositories\ApartmentRepository;
use App\User;
use Illuminate\Http\Request;
use App\Menu;
use Illuminate\Support\Facades\Hash;
use MenusRepository;

class IndexController extends SiteController
{
    public function __construct(ApartmentRepository $a_rep)
    {
        parent::__construct(new \App\Repositories\MenusRepository(new \App\Menu));

        $this->a_rep = $a_rep;

        $this->template = config('settings.theme').'.main.index';
    }

    public function index(Request $request)
    {
        $apartments = $this->a_rep->get(['title', 'img', 'price', 'alias', 'rooms', 'square'], FALSE, TRUE, ['status', 1]);

        if ($request->ajax()) {
            if (empty($apartments)) {
                return 'empty';
            }
            $view = view(config('settings.theme').'.elements.data', compact('apartments'))->render();
            return response()->json(['html' =>  $view]);
        }

        $content = view(config('settings.theme').'.elements.content')->with('apartments', $apartments)->render();
        $this->vars = array_add($this->vars,'content',$content);

        $search = view(config('settings.theme').'.elements.search')->render();
        $this->vars = array_add($this->vars,'search',$search);

        return $this->renderOutput();
    }

}
