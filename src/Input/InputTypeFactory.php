<?php

declare(strict_types=1);

namespace pointybeard\Helpers\Cli\Input;

use pointybeard\Helpers\Functions\Flags;
use pointybeard\Helpers\Foundation\Factory;

final class InputTypeFactory extends Factory\AbstractFactory
{
    use Factory\Traits\hasSimpleFactoryBuildMethodTrait;
    
    public static function getTemplateNamespace(): string
    {
        return __NAMESPACE__.'\\Types\\%s';
    }

    public static function getExpectedClassType(): ?string
    {
        return __NAMESPACE__.'\\Interfaces\\InputTypeInterface';
    }
}
