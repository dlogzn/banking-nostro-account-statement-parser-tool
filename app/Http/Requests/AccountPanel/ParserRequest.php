<?php

namespace App\Http\Requests\AccountPanel;

use Illuminate\Foundation\Http\FormRequest;

class ParserRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];
        $rules['file'] = [
            'required',
            'mimes:txt'
        ];
        return $rules;
    }
}
