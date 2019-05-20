<?php

declare(strict_types=1);

namespace pointybeard\Helpers\Cli\Input\Exceptions;

class RequiredArgumentMissingException extends \Exception
{
    private $argument;

    public function __construct(string $argument, $code = 0, \Exception $previous = null)
    {
        $this->argument = strtoupper($argument);

        return parent::__construct("missing argument {$this->argument}.", $code, $previous);
    }

    public function getArgumentName(): string
    {
        return $this->argument;
    }
}
