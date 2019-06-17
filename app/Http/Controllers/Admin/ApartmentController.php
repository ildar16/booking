<?php

namespace App\Http\Controllers\Admin;

use App\Apartment;
use App\Repositories\ApartmentRepository;
use App\Repositories\BooksRepository;
use Illuminate\Http\Request;

class ApartmentController extends AdminController
{
    public function __construct(ApartmentRepository $a_rep, BooksRepository $b_rep)
    {
        parent::__construct();
        $this->a_rep = $a_rep;
        $this->b_rep = $b_rep;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        $this->title = "Apartment books - " . $apartment->title;

        $books = $this->b_rep->get('*', false, false, ['apartment_id', $apartment->id]);
        if ($books) {
            $books->load('user');
        }

        $content = view('standart.admin.show_books')->with('books', $books)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();
    }

    public function updateStatus(Apartment $apartment, Request $request)
    {
        $apartment->status = $request->status;
        $apartment->update();
    }

    public function filter(Request $request)
    {
        dd($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
