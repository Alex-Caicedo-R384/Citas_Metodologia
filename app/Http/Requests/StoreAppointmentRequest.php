<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'partner_id' => ['required', 'exists:users,id'],
            'date' => ['required', 'date'],
        ];
    }
}
