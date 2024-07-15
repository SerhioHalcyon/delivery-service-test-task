<?php

namespace App\Jobs;

use App\Enums\DeliveryStatus;
use App\Facades\Delivery;
use App\Models\Delivery as DeliveryModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Redelivery implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private DeliveryModel $deliveryModel)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->deliveryModel->fresh();

        if ($this->deliveryModel->status !== DeliveryStatus::FAILED) {
            return;
        }

        $response = Delivery::sendParcel($this->deliveryModel->toDeliveryData());

        if ($response->successful()) {
            $this->deliveryModel->status = DeliveryStatus::SENT;
            $this->deliveryModel->save();
        }
    }
}
