<?php

declare(strict_types=1);

namespace pointybeard\Helpers\Cli\Input\Exceptions;

class InputHandlerNotFoundException extends \Exception
{
    public function __construct(string $handler, string $command, $code = 0, \Exception $previous = null)
    {
        return parent::__construct(sprintf('The input handler %s could not be located.', $handler), $code, $previous);
    }
}
