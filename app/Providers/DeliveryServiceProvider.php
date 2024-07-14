<?php

namespace App\Providers;

use App\Contracts\Delivery\Delivery as DeliveryContract;
use App\Facades\Delivery\{
    NovaPoshta\Accessor as NovaPoshtaAccessor,
    UkrPoshta\Accessor as UkrPoshtaAccessor,
    Justin\Accessor as JustinAccessor,
};
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
            $provider = config('delivery.default');

            return $app->make(config("delivery.providers.{$provider}.driver"));
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
