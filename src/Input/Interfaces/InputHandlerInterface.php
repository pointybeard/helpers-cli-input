<?php

declare(strict_types=1);

namespace pointybeard\Helpers\Cli\Input\Interfaces;

use pointybeard\Helpers\Cli\Input;

interface InputHandlerInterface
{
    public function bind(Input\InputCollection $inputCollection, bool $skipValidation = false): bool;

    public function validate(): void;

    public function getArgument(string $name): ?string;

    // note that the return value of getOption() isn't always going to be
    // a string like getArgument()
    public function getOption(string $name);

    public function getArguments(): array;

    public function getOptions(): array;

    public function getCollection(): ?Input\InputCollection;
}
