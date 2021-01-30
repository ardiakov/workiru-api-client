<?php

declare(strict_types=1);

namespace Ardiakov\Workiru\Exceptions;

use Exception;

/**
 * Class AuthFailed
 *
 * @author Artem Diakov <adiakov.work@gmail.com>
 */
final class WorkiException extends Exception
{
    public function __construct($code, string $message = '')
    {
        parent::__construct($message, $code);
    }
}