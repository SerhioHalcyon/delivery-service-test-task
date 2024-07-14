<?php

namespace App\Http\Controllers;

use App\Contracts\Delivery\Delivery as DeliveryContract;
use App\Facades\Delivery;
use App\Http\Requests\DeliveryRequest;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function __construct(private DeliveryContract $delivery)
    {
        //
    }

    public function store(DeliveryRequest $request)
    {
        // If you prefer injections, use contracts.
        // dd($this->delivery->getProviderName());
        // If you prefer facades and static calls
        // dd(Delivery::getProviderName());

        // Sometimes a DTO can be used for this structure
        $data = [
            'customer_name' => $request->validated()['user']['name'],
            'phone_number' => $request->validated()['user']['phone'],
            'sender_address' => $this->delivery->getProviderAddress(),
            'delivery_address' => $request->validated()['user']['address'],
        ];

        $this->delivery->sendParcel($data);
dd($data);

        return true;
    }
}
