<?php

namespace App\Http\Controllers;

use App\Contracts\Delivery\Delivery as DeliveryContract;
use App\Enums\DeliveryStatus;
use App\Facades\Delivery;
use App\Http\Requests\DeliveryRequest;
use App\Http\Response;
use App\Jobs\Redelivery;
use App\Services\DeliveryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeliveryController extends Controller
{
    public function __construct(
        private DeliveryContract $delivery,
        private DeliveryService $deliveryService,
    ) {
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

        $deliveryModel = $this->deliveryService
            ->store($data + ['status' => DeliveryStatus::PENDING]);

        // I created a method to change the provider,
        // but it works only for the facade.
        // Delivery::provider('justin')->getProviderName();
        // Delivery::getProviderName();

        // You can send a parcel immediately or set a job for this
        try {
            $response = $this->delivery->sendParcel($deliveryModel->toDeliveryData());
        } catch (Exception $e) {
            Log::error('Failed to send parcel: ' . $e->getMessage());

            $this->deliveryService->update($deliveryModel, ['status' => DeliveryStatus::FAILED]);

            // Sent a request for the next day if with delivery server is down.
            Redelivery::dispatch($deliveryModel)->delay(now()->addDay());
        }

        // Sent a request an hour later if delivery server can`t handle a request now.
        // This is a simple example, of course, some services realize more requests
        // to the service after 5m, 10m, 1h, 12h and 24h.
        if ($response->failed()) {
            $this->deliveryService->update($deliveryModel, ['status' => DeliveryStatus::FAILED]);

            Redelivery::dispatch($deliveryModel)->delay(now()->addHour());
        } else {
            $this->deliveryService->update($deliveryModel, ['status' => DeliveryStatus::SENT]);
        }

        return Response::send(true);
    }
}
