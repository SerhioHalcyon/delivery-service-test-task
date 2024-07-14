<?php

namespace App\Contracts\Delivery;

interface Delivery
{
    public function getProviderName(): string;
    public function getProviderAddress(): string;
    public function sendParcel(array $data): array;
}
