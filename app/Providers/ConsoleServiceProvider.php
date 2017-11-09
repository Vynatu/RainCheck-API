<?php

namespace RainCheck\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

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
