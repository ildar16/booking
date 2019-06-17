<?php

namespace App\Http\Controllers\Cabinet;

use App\Book;
use App\Repositories\BooksRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends CabinetController
{
    public function __construct(BooksRepository $b_rep)
    {
        $this->b_rep = $b_rep;

        $this->template = config('settings.theme') . '.cabinet.index';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->title = "My books";

        $user_id = Auth::id();
        $books = $this->b_rep->get('*', false, false, ['user_id', $user_id]);
        if ($books) {
            $books->load('apartment');
        }
//dd($books);
        $content = view(config('settings.theme') . '.cabinet.books')->with('books', $books)->render();
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
    public function show($id)
    {
        //
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
    public function destroy(Book $book)
    {
        $result = $this->b_rep->deleteBook($book);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return redirect('/cabinet')->with($result);
    }
}
