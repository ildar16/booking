<?php

namespace App\Http\Requests;

use App\Apartment;
use Illuminate\Validation\Rule;

class BookRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function all($keys = null)
    {
        $input = parent::all();

        $input['book_start'] = date("Y-m-d", strtotime($input['book_start']));
        $input['book_end'] = date("Y-m-d", strtotime($input['book_end']));

        return $input;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $apartment_id = Apartment::where('alias', $this->route()->alias)->first()->id;
        $rules = [
            'book_start' => [
                'required',
                'date_format:Y-m-d',
                Rule::unique('books')->where(function ($query) use ($apartment_id) {
                    return $query->where('apartment_id', $apartment_id);
                })],
            'book_end' => [
                'required',
                'date_format:Y-m-d',
                Rule::unique('books')->where(function ($query) use ($apartment_id) {
                    return $query->where('apartment_id', $apartment_id);
                })],
        ];

        return $rules;
    }
}
