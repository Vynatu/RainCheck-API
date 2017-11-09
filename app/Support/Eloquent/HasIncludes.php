<?php

namespace RainCheck\Support\Eloquent;

trait HasIncludes
{
    /**
     * Begin querying a model with eager loading, with
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function withIncludes()
    {
        if ($requested_includes = app('request')->input('include')) {
            $relations = self::getIncludableRelations();
            $filtered_relations = array_intersect($relations, explode(',', $requested_includes));
            if (count($filtered_relations) > 0) {
                return (new static)->newQuery()->with(
                    $filtered_relations
                );
            }
        }

        return (new static)->newQuery();
    }

    public static function getIncludableRelations()
    {
        return property_exists(static::class, 'includable') ? static::$includable : [];
    }
}