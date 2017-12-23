<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
            'subject' => 'required|string',
            'deadline' => 'required|after:'.now(),
            'team' => 'required|numeric',
            'content' => 'required|string',
            'image' => 'mimes:jpg,jpeg,png',
            'relaters' => 'array'
        ];
    }
}
