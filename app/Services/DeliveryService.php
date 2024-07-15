<?php

namespace App\Services;

use App\Models\Delivery;
use App\Repositories\DeliveryRepository;

class DeliveryService
{
    public function __construct(private DeliveryRepository $deliveryRepository)
    {
        //
    }

    public function store(array $data): Delivery
    {
        return $this->deliveryRepository->create($data);
    }

    public function update(Delivery $delivery, array $data): Delivery
    {
        return $this->deliveryRepository->update($delivery, $data);
    }
}
