<?php

declare(strict_types=1);

namespace pointybeard\Helpers\Cli\Input;

use pointybeard\Helpers\Functions\Flags;
use pointybeard\Helpers\Foundation\Factory;

final class InputHandlerFactory extends Factory\AbstractFactory
{
    public static function getTemplateNamespace(): string
    {
        return __NAMESPACE__.'\\Handlers\\%s';
    }

    public static function getExpectedClassType(): ?string
    {
        return __NAMESPACE__.'\\Interfaces\\InputHandlerInterface';
    }

    public static function build(string $name, InputCollection $collection = null, int $flags = null): Interfaces\InputHandlerInterface
    {
        try {
            $handler = self::instanciate(
                self::generateTargetClassName($name)
            );
        } catch (\Exception $ex) {
            throw new Exceptions\UnableToLoadInputHandlerException($name, 0, $ex);
        }

        if ($collection instanceof InputCollection) {
            $handler->bind(
                $collection,
                $flags
            );
        }

        return $handler;
    }
}
