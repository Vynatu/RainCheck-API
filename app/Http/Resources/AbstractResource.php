<?php

namespace RainCheck\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\Resource;

class AbstractResource extends Resource
{
    public function __construct($resource)
    {
        if ($resource instanceof Model) {

        }

        parent::__construct($resource);
    }
}
