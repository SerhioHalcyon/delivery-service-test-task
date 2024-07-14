<?php

namespace App\Providers;

use App\Contracts\Delivery\Delivery as DeliveryContract;
use App\Enums\DeliveryProvider;
use App\Facades\Delivery\NovaPoshta\Accessor;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

// Implement `DeferrableProvider` because that is the last part in shopping.
// If Delivery feature uses all time - remove it
class DeliveryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DeliveryContract::class, function (Application $app) {
            // Use config because this part is more stable.
            switch (config('delivery.default')) {
                case config('delivery.providers.novaposhta.driver'):
                    return new Accessor();
            }
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [DeliveryContract::class];
    }
}
