<?php

namespace App\Contracts\Delivery;

use Illuminate\Http\Client\Response;

interface Delivery
{
    public function getProviderName(): string;
    public function getProviderAddress(): string;
    public function sendParcel(array $data): Response;
}
