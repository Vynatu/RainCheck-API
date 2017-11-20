<?php

namespace RainCheck\Support\Eloquent;

use Illuminate\Database\Eloquent\Model;

trait HasUniqueToken
{
    public static function bootHasUniqueToken()
    {
        static::creating(
            function (Model $model) {
                $model->generateUniqueToken(false);
            }
        );
    }

    public function generateUniqueToken($save = true)
    {
        $this->forceFill(
            [
                $this->getUniqueTokenColumn() => str_random($this->getUniqueTokenLength()),
            ]
        );

        if ($save) {
            $this->save();
        }
    }

    public function getRouteKeyName()
    {
        return $this->getUniqueTokenColumn();
    }

    public function getUniqueTokenColumn()
    {
        return property_exists($this, 'unique_token_column')
            ? $this->unique_token_column
            : 'resource_token';
    }

    public function getUniqueTokenLength()
    {
        return property_exists($this, 'unique_token_length')
            ? $this->unique_token_length
            : 12;
    }

    public function shouldReturnIdAsToken()
    {
        return property_exists($this, 'return_token_as_id')
            ? $this->return_token_as_id
            : true;
    }

    /**
     * Changes the ID attribute to the unique token column.
     */
    public function toArray()
    {
        $a = parent::toArray();

        if ($this->shouldReturnIdAsToken()) {
            $unique_column = $this->getUniqueTokenColumn();

            unset($a[$unique_column]);
            $a['id'] = $this->getAttribute($unique_column);
        }

        return $a;
    }
}
