<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Delivery extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        /*
        | In previous version of Laravel, there was an "alias" in `config/app`
        | and we could bind a string to a facade.
        | But now Laravel uses composer to bind it`s own facades as subpackages.
        | I think this makes it difficult to develop and maintain.
        | Therefore, I propose to use a contract for this method.
        */
        return \App\Contracts\Delivery\Delivery::class;
    }

    // This feature is still in the testing stage.
    public static function provider(string $provider)
    {
        return app(config('delivery.providers.' . $provider)['driver']);
    }
}
