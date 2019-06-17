<?php

namespace App\Http\Controllers;

use App\Repositories\MenusRepository;
use Menu;

class SiteController extends Controller
{
    protected $m_rep;
    protected $a_rep;
    protected $b_rep;

    protected $title;
    protected $meta_desc;

    protected $vars = [];

    protected $template;

    public function __construct(MenusRepository $m_rep) {
        $this->m_rep = $m_rep;
    }

    protected function renderOutput()
    {
        $this->vars = array_add($this->vars,'title',$this->title);
        $menu = $this->getMenu();
        $navigation = view(config('settings.theme').'.elements.navigation')->with('menu',$menu)->render();
        $this->vars = array_add($this->vars,'navigation',$navigation);

        $footer = view(config('settings.theme').'.blocks.footer')->render();
        $this->vars = array_add($this->vars,'footer',$footer);

        return view($this->template)->with($this->vars);
    }

    public function getMenu() {

        $menu = $this->m_rep->get();

        $mBuilder = Menu::make('MyNav', function($m) use ($menu) {

            foreach($menu as $item) {

                if($item->parent == 0) {
                    $m->add($item->title,$item->path)->id($item->id);
                }
                else {
                    if($m->find($item->parent)) {
                        $m->find($item->parent)->add($item->title,$item->path)->id($item->id);
                    }
                }
            }

        });

        return $mBuilder;
    }
}
