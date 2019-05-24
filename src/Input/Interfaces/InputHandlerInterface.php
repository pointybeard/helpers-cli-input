<?php

declare(strict_types=1);

namespace pointybeard\Helpers\Cli\Input\Interfaces;

use pointybeard\Helpers\Cli\Input;

interface InputHandlerInterface
{
    public function bind(Input\InputCollection $inputCollection, bool $skipValidation = false): bool;

    public function validate(): void;

    public function find(string $name);

    public function getInput(): array;

    public function getCollection(): ?Input\InputCollection;
}
