<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\Book;
use App\Comfort;
use App\Filters\ApartmentFilter;
use App\Http\Requests\BookRequest;
use App\Repositories\ApartmentRepository;
use App\Repositories\BooksRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Config;

class ApartmentController extends SiteController
{

    public function __construct(ApartmentRepository $a_rep, BooksRepository $b_rep)
    {
        parent::__construct(new \App\Repositories\MenusRepository(new \App\Menu));

        $this->a_rep = $a_rep;
        $this->b_rep = $b_rep;

        $this->template = config('settings.theme') . '.main.apartments';
    }


    public function index()
    {
        $content = view(config('settings.theme') . '.apartment')->render();
        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();
    }

    public function show($alias = FALSE, Request $request)
    {
        $apartment = $this->a_rep->one($alias, ['books' => true], ['status', 1]);

        if (empty($apartment)) {
            return abort(404);
        }

        $userId = Auth::id();
        $userBooks = [];
        $userResult = [];
        $comforts = [];

        if ($apartment->comforts) {
            $comforts = Comfort::find(explode(",", $apartment->comforts));
        }

        $this->vars = array_add($this->vars, 'title', $apartment->title);
        $apartment->book = $apartment->book->where('book_end', '>=', Carbon::now()->toDateString());

        $result = [];
        $dates = [];

        if (!$apartment->book->isEmpty()) {
            foreach ($apartment->book as $book) {
                if ($book['user_id'] == $userId) {
                    $userBooks[] = $this->b_rep->createDateRange($book['book_start'], $book['book_end']);
                }
                $dates[] = $this->b_rep->createDateRange($book['book_start'], $book['book_end']);
            }
            $result = call_user_func_array('array_merge', $dates);
            if ($userBooks) {
                $userResult = call_user_func_array('array_merge', $userBooks);
            }
        }

        usort($result, function($a1, $a2) {
            $v1 = strtotime($a1);
            $v2 = strtotime($a2);
            return $v1 - $v2;
        });

        $content = view(config('settings.theme') . '.apartment')->with(['apartment' => $apartment, 'dates' => $result, 'comforts' => $comforts, 'userBooks' => $userResult])->render();
        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $start = Carbon::parse($request->start_date)->startOfDay();
        $end = Carbon::parse($request->end_date)->endOfDay();

        $get_apartment_id = Book::whereRaw('? between book_start and book_end OR ? between book_start and book_end', [$start, $end])->orwhereBetween('book_start', [$start, $end])->orwhereBetween('book_end', [$start, $end])->pluck('apartment_id')->toArray();

        $empty_apartments = Apartment::all()->except($get_apartment_id);

        $content = view(config('settings.theme') . '.search_results')->with('empty_apartments', $empty_apartments)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();
    }

    public function filter(Request $request)
    {
        $apartments = Apartment::where('status', 1)->with('book');

        $this->title = "Filter";

        $apartments = (new ApartmentFilter($apartments, $request))->apply()->paginate(Config::get('settings.paginate'));

        if ($request->ajax()) {
            if ($apartments->isEmpty()) {
                return 'empty';
            }
            $view = view(config('settings.theme').'.elements.data', compact('apartments'))->render();
            return response()->json(['html' =>  $view]);
        }

        $content = view(config('settings.theme') . '.rooms')->with('apartments', $apartments)->render();
        $this->vars = array_add($this->vars, 'content', $content);

        return $this->renderOutput();
    }

    public function createBook(BookRequest $request, $alias)
    {
        $apartment = $this->a_rep->one($alias);

        $result = $this->b_rep->createBook($apartment, $request);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return back()->with($result);
    }
}
