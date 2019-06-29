<?php

namespace App\Http\Controllers\Admin;

use App\Apartment;
use App\Repositories\ApartmentRepository;
use Illuminate\Http\Request;

class IndexController extends AdminController
{
    public function __construct(ApartmentRepository $a_rep)
    {
        $this->template = config('settings.theme') . '.admin.index';

        $this->a_rep = $a_rep;
    }

    public function index()
    {
        $this->title = "Admin";

        $apartments = Apartment::with('book')->with('user')->paginate(10);

        $content = view(config('settings.theme') . '.admin.home')->with('apartments', $apartments)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
