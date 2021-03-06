<?php

namespace RainCheck\Support\Contracts\Eloquent;

interface HasUniqueToken
{
    /**
     * Generates a unique token for a specific resource.
     *
     * @return mixed
     */
    public function generateUniqueToken();

    public function getUniqueTokenColumn();

    public function getUniqueTokenLength();

    public function shouldReturnIdAsToken();
}
