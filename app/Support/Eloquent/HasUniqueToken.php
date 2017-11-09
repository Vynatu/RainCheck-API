<?php

namespace RainCheck\Support\Eloquent;

trait HasUniqueToken
{
    protected $return_token_as_id = true;

    public static function bootHasUniqueToken()
    {
        static::creating(
            function ($model) {
                $model->generateUniqueToken(false);
            }
        );
    }

    public function generateUniqueToken($save = true)
    {
        $unique_column = property_exists($this, 'unique_token_column') ? $this->unique_token_column : 'resource_token';
        $token_length = property_exists($this, 'unique_token_length') ? $this->unique_token_length : 12;

        $this->forceFill(
            [
                $unique_column => str_random($token_length),
            ]
        );

        if ($save) {
            $this->save();
        }
    }

    public function getRouteKeyName()
    {
        return property_exists($this, 'unique_token_column') ? $this->unique_token_column : 'resource_token';
    }

    /**
     * Changes the ID attribute to the unique token column
     */
    public function toArray()
    {
        $a = parent::toArray();

        if (property_exists($this, 'return_token_as_id') ? $this->return_token_as_id : true) {
            $unique_column = property_exists($this, 'unique_token_column')
                ? $this->unique_token_column
                : 'resource_token';

            unset($a[$unique_column]);
            $a['id'] = $this->getAttribute($unique_column);
        }

        return $a;
    }
}