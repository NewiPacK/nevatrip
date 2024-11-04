<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\V1\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        return OrderResource::collection(Order::all());
    }

    public function store(StoreOrderRequest $request)
    {
        $data = $request->all();

        do {

            $data['barcode'] = $this->generateUniqueBarcode();


            $bookingResponse = $this->mockBookingApi([
                'event_id' => $data['event_id'],
                'event_date' => $data['event_date'],
                'ticket_adult_price' => $data['ticket_adult_price'],
                'ticket_adult_quantity' => $data['ticket_adult_quantity'],
                'ticket_kid_price' => $data['ticket_kid_price'],
                'ticket_kid_quantity' => $data['ticket_kid_quantity'],
                'barcode' => $data['barcode'],
            ]);


            Log::info('Booking API response:', $bookingResponse);

        } while (isset($bookingResponse['error']) && $bookingResponse['error'] === 'barcode already exists');


        if (isset($bookingResponse['message']) && $bookingResponse['message'] === 'order successfully booked') {

            $confirmationResponse = $this->confirmOrder($data['barcode']);


            Log::info('Confirmation API response:', $confirmationResponse);


            if (isset($confirmationResponse['message']) && $confirmationResponse['message'] === 'order successfully aproved') {

                return new OrderResource(Order::create($data));
            } else {

                Log::error('Order confirmation failed:', $confirmationResponse);
                return response()->json(['error' => 'Order confirmation failed', $confirmationResponse], 400);
            }
        }
    }

    private function generateUniqueBarcode()
    {
        // Используем блокировку, чтобы избежать дублирования в конкурентных запросах
        return Cache::lock('barcode_generation', 10)->get(function () {
            do {
                // Генерируем случайный 8-значный штрих-код
                $barcode = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
            } while (Order::where('barcode', $barcode)->exists());

            return $barcode;
        });
    }

    private function mockBookingApi($data)
    {
        return rand(0, 1) === 1
            ? ['message' => 'order successfully booked']
            : ['error' => 'barcode already exists'];
    }

    private function confirmOrder($barcode)
    {
        $response = rand(0, 1) === 1
            ? ['message' => 'order successfully aproved']
            : $this->mockErrorResponse();

        return $response;
    }

    private function mockErrorResponse()
    {
        $errors = [
            ['error' => 'event cancelled'],
            ['error' => 'no tickets'],
            ['error' => 'no seats'],
            ['error' => 'fan removed']
        ];

        return $errors[array_rand($errors)];
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function update(Request $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        //
    }
}
