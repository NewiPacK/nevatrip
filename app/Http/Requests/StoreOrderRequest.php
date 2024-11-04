<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest  extends FormRequest
{
    public function rules(): array
    {
        return [
            'event_id' => 'required',
            'event_date' => 'required',
            'ticket_adult_price' => 'required',
            'ticket_adult_quantity' => 'required',
            'ticket_kid_price' => 'required',
            'ticket_kid_quantity' => 'required',
            'user_id' => 'required',
            'equal_price' => 'required'
        ];
    }
}
