<?php

namespace App\Http\Requests\SingleApplication;

use Illuminate\Foundation\Http\FormRequest;

class GetMatchesByParameterRequest extends FormRequest
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
    public function rules()
    {
        return [
            'season' => 'required|numeric|exists:seasons,id',
            'week' => 'required|numeric|exists:matches,week_number',
        ];
    }
}
