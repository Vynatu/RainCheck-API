<?php

namespace RainCheck\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerSchemaMacros();
        }
    }

    protected function registerSchemaMacros()
    {
        Blueprint::macro('uniqueToken',
            function ($column = 'resource_token', $length = 12) {
                $this->string($column, $length)->unique();
            }
        );
    }
}
