<?php
namespace App\Repositories;

use App\Book;
use DateInterval;
use DatePeriod;
use DateTime;

class BooksRepository extends Repository
{
    public function __construct(Book $book)
    {
        $this->model = $book;
    }

    public function createBook($apartment, $request)
    {
        $data = $request->except('_token');

        $data['book_start'] = date('Y-m-d', strtotime($data['book_start']));
        $data['book_end'] = date('Y-m-d', strtotime($data['book_end']));
        $data['apartment_id'] = $apartment->id;

        $apartmentBooks = [];
        $result = [];

        if (!$apartment->book->isEmpty()) {
            foreach ($apartment->book as $book) {
                $apartmentBooks[] = $this->createDateRange($book['book_start'], $book['book_end']);
            }

            $result = call_user_func_array('array_merge', $apartmentBooks);
        }

        $newBook =$this->createDateRange($request->book_start, $request->book_end);

        if (count(array_intersect($result, $newBook)) > 0) {
            return ['error' => 'Apartment is busy'];
        }

        $this->model->fill($data);

        if ($request->user()->books()->save($this->model)) {
            return ['status' => 'Book added'];
        }
    }

    public function createDateRange($startDate, $endDate, $format = "d-m-Y")
    {
        $begin = new DateTime($startDate);
        $end = new DateTime($endDate);
        $end = $end->modify('+1 day');

        $interval = new DateInterval('P1D');
        $dateRange = new DatePeriod($begin, $interval, $end);

        $range = [];
        foreach ($dateRange as $date) {
            $range[] = $date->format($format);
        }
        return $range;
    }

    public function deleteBook($book)
    {
        if ($book->delete()) {
            return ['status' => 'Book deleted'];
        }
    }

}