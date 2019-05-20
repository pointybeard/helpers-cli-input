<?php

declare(strict_types=1);

namespace pointybeard\Helpers\Cli\Input\Types;

use pointybeard\Helpers\Functions\Flags;
use pointybeard\Helpers\Functions\Strings;
use pointybeard\Helpers\Cli\Input;

class Option extends Input\AbstractInputType
{
    protected $long;
    protected $default;

    public function __construct(string $name, string $long = null, int $flags = null, string $description = null, object $validator = null, $default = false)
    {
        $this->default = $default;
        $this->long = $long;
        parent::__construct($name, $flags, $description, $validator);
    }

    public function __toString()
    {
        $long = null !== $this->long() ? ', --'.$this->long() : null;
        if (null != $long) {
            if (Flags\is_flag_set($this->flags(), self::FLAG_VALUE_REQUIRED)) {
                $long .= '=VALUE';
            } elseif (Flags\is_flag_set($this->flags(), self::FLAG_VALUE_OPTIONAL)) {
                $long .= '[=VALUE]';
            }
        }
        $first = str_pad(sprintf('-%s%s    ', $this->name(), $long), 36, ' ');

        $second = Strings\utf8_wordwrap_array($this->description(), 40);
        for ($ii = 1; $ii < count($second); ++$ii) {
            $second[$ii] = str_pad('', 38, ' ', \STR_PAD_LEFT).$second[$ii];
        }

        return $first.implode($second, PHP_EOL);
    }
}
