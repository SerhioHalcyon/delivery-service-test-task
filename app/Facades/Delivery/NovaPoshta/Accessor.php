<?php

namespace App\Facades\Delivery\NovaPoshta;

use App\Contracts\Delivery\Delivery;
use Illuminate\Support\Facades\Http;

class Accessor implements Delivery
{
    public function getProviderName(): string
    {
        return 'NovaPoshta';
    }
    public function getProviderAddress(): string
    {
        $provider = config('delivery.default');

        return config("delivery.providers.{$provider}.address");
    }

    public function sendParcel(array $data): array
    {
        $response = Http::post('novaposhta.test/api/delivery', $data);

        return $response->json();
    }
}
