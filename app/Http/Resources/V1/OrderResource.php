<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'event_date' => $this->event_date,
            'ticket_adult_price' => $this->ticket_adult_price,
            'ticket_adult_quantity' => $this->ticket_adult_quantity,
            'ticket_kid_price' => $this->ticket_kid_price,
            'ticket_kid_quantity' => $this->ticket_kid_quantity,
            'barcode' => $this->barcode,
            'user_id' => $this->user_id,
            'equal_price' => $this->equal_price,
            'created' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),

        ];
    }
}
