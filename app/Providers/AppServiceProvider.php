<?php

namespace RainCheck\Providers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootSerializers();
        $this->bootMacros();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boots model macros
     */
    protected function bootMacros()
    {
        Collection::macro('withIncludes', function() {
            if ($requested_includes = app('request')->input('include')) {
                $relations = $this->getQueueableClass()::getIncludableRelations();
                $filtered_relations = array_intersect($relations, explode(',', $requested_includes));
                if (count($filtered_relations) > 0) {
                    $this->load($filtered_relations);
                }
            }

            return $this;
        });
    }

    /**
     *
     */
    protected function bootSerializers()
    {
        Carbon::serializeUsing(function($carbon) {
            return $carbon->format('c');
        });
    }
}
