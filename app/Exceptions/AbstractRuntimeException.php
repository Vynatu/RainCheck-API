<?php

namespace RainCheck\Exceptions;

use Exception;

abstract class AbstractRuntimeException extends Exception
{
    /**
     * An application-specific error code, expressed as a string value.
     *
     * @var string
     */
    protected $code = 'E_500';

    /**
     * A short, human-readable summary of the problem that
     * SHOULD NOT change from occurrence to occurrence of
     * the problem, except for purposes of localization.
     *
     * @var string
     */
    protected $title = 'Server Error';

    /**
     * A link that leads to further details about this particular
     * occurrence of the problem. Will be under the links object.
     * You may omit this field and allow this exception class to
     * take the error code defined above and build a link from
     * the documentation's base URL, defined below.
     *
     * @var string|null
     */
    protected $about_link = null;

    /**
     * A meta object containing non-standard meta-information about the error.
     *
     * @var array
     */
    protected $meta = [];

    /**
     * Used in the case of ommitting the about link defined
     * above. Add a trailing slash.
     *
     * @var string
     */
    protected $docs_base = 'https://raincheck.vynatu.io/docs/exceptions/';

    /**
     * AbstractRuntimeException constructor.
     *
     * @param string|null     $message
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = null, $code = 0, \Throwable $previous = null)
    {
        // We can have a generic message and a context-defined message.
        if ($message !== null) {
            $this->message = $message;
        } else {
            $this->message = $this->title;
        }

        parent::__construct($this->message, $code, $previous);
    }
}
