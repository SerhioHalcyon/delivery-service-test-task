<?php

namespace App\Facades\Delivery\Justin;

use App\Contracts\Delivery\Delivery;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Accessor implements Delivery
{
    public function getProviderName(): string
    {
        return 'Justin';
    }
    public function getProviderAddress(): string
    {
        $provider = config('delivery.default');

        return config("delivery.providers.{$provider}.address");
    }

    public function sendParcel(array $data): Response
    {
        $response = Http::post('novaposhta.test/api/delivery', $data);

        return $response;
    }
}
