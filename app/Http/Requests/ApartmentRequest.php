<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ApartmentRequest extends Request
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

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('alias', 'unique:apartments|max:255', function ($input) {
            if ($this->route()->hasParameter('apartment')) {
                $model = $this->route()->parameter('apartment');

                return ($model->alias !== $input->alias) && !empty($input->alias);
            }

            return !empty($input->alias);

        });

        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == "POST") {
            $rules = [
                'title' => 'required|max:100|regex:/(^([a-zA-Z0-9- ]+)(\d+)?$)/u',
                'rooms' => 'required|integer',
                'alias' => 'required|max:255',
                'img' => 'required',
                'img.*' => 'required|mimes:jpeg,jpg,png|max:1000|image',
            ];
        } else {
            $rules = [
                'title' => 'required|max:100|regex:/(^([a-zA-Z0-9- ]+)(\d+)?$)/u',
                'rooms' => 'required|integer',
                'alias' => 'required|max:100|regex:/(^([a-zA-Z0-9-]+)(\d+)?$)/u',
                'img.*' => 'required|mimes:jpeg,jpg,png|max:1000|image',
                "delete"    => "nullable|array",
                "delete.*"  => "nullable|string|distinct",
            ];
        }

        return $rules;
    }
}
