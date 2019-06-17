<?php

namespace App\Http\Controllers\Cabinet;

use App\Repositories\ApartmentRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class IndexController extends CabinetController
{

    public function __construct(ApartmentRepository $a_rep)
    {
        $this->template = config('settings.theme') . '.cabinet.index';

        $this->a_rep = $a_rep;
    }

    public function index()
    {
        $this->title = "Cabinet";
        $userId = Auth::id();
        $apartments = $this->a_rep->userApartment($userId);

        $content = view(config('settings.theme').'.cabinet.home')->with('apartments', $apartments)->render();
        $this->vars = array_add($this->vars,'content',$content);

        return $this->renderOutput();
    }

}
