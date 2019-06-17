<?php

namespace App\Http\Controllers\Cabinet;

use App\Apartment;
use App\Http\Requests\ApartmentRequest;
use App\Repositories\ApartmentRepository;
use App\Repositories\BooksRepository;

class ApartmentController extends CabinetController
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
        $this->title = "Add apartment";

        $content = view(config('settings.theme') . '.cabinet.create_apartment')->render();
        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApartmentRequest $request)
    {
        if ($this->a_rep->checkApartmentCount()) {
            return redirect('/cabinet')->withErrors("You are already created " . config('settings.apartments.user_count_create') . " apartments");
        }

        $result = $this->a_rep->createApartment($request);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/cabinet')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        $this->title = "Apartment books - " . $apartment->title;

        if ($this->a_rep->checkApartmentOwner($apartment)) {
            return redirect('/cabinet');
        }

        $books = $this->b_rep->get('*', false, false, ['apartment_id', $apartment->id]);
        if ($books) {
            $books->load('user');
        }

        $content = view(config('settings.theme') . '.cabinet.show_books')->with(['books' => $books])->render();
        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        $apartment_owner = $this->a_rep->checkApartmentOwner($apartment);
        if ($apartment_owner) {
            return abort(404);
//            return redirect("/cabinet");
        }

        $this->title = "Edit apartment - " . $apartment->title;

        $content = view(config('settings.theme') . '.cabinet.update_apartment')->with(['apartment' => $apartment])->render();
        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApartmentRequest $request, Apartment $apartment)
    {
        $result = $this->a_rep->updateApartment($request, $apartment);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/cabinet')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        $apartment_owner = $this->a_rep->checkApartmentOwner($apartment);
        if ($apartment_owner) {
            return redirect("/cabinet");
        }

        $result = $this->a_rep->deleteApartment($apartment);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/cabinet')->with($result);
    }
}
