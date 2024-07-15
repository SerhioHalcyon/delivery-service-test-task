<?php

namespace App\Models;

use App\Enums\DeliveryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// I think this model should be independent of others.
// Because the user can change some information about themselves
// or the delivery provider can change the information.
// But the package should still be delivered
// according to the data that was there when it was created.
class Delivery extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'customer_name',
        'phone_number',
        'sender_address',
        'delivery_address',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => DeliveryStatus::class,
        ];
    }

    public function toDeliveryData()
    {
        return [
            'customer_name' => $this->customer_name,
            'phone_number' => $this->phone_number,
            'sender_address' => $this->sender_address,
            'delivery_address' => $this->delivery_address,
        ];
    }
}
