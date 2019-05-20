<?php

declare(strict_types=1);

namespace pointybeard\Helpers\Cli\Input\Types;

use pointybeard\Helpers\Cli\Input;
use pointybeard\Helpers\Functions\Strings;

class Argument extends Input\AbstractInputType
{
    public function __toString()
    {
        $name = strtoupper($this->name());

        $first = str_pad(sprintf('%s    ', $name), 20, ' ');

        $second = Strings\utf8_wordwrap_array($this->description(), 40);
        for ($ii = 1; $ii < count($second); ++$ii) {
            $second[$ii] = str_pad('', 22, ' ', \STR_PAD_LEFT).$second[$ii];
        }

        return $first.implode($second, PHP_EOL);
    }
}
