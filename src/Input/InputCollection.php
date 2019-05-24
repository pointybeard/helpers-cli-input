<?php

declare(strict_types=1);

namespace pointybeard\Helpers\Cli\Input;

class InputCollection
{
    private $items = [];

    // Prevents the class from being instanciated
    public function __construct()
    {
    }

    public function append(Interfaces\InputTypeInterface $input, bool $replace = false): self
    {
        $class = new \ReflectionClass($input);

        $index = null;
        $type = null;

        if (!$replace && null !== $this->find($input->name(), null, null, $index, $type)) {
            throw new \Exception("{$class->getShortName()} '{$input->name()}' already exists in this collection");
        }

        if (true == $replace && null !== $index) {
            $this->items[$class->getShortName()][$index] = $argument;
        } else {
            $this->items[$class->getShortName()][] = $input;
        }

        return $this;
    }

    public function find(string $name, array $restrictToType=null, array $excludeType=null, &$type = null, &$index = null): ?AbstractInputType
    {
        foreach($this->items as $type => $items) {

            // Check if we're restricting to or excluding specific types
            if(null !== $restrictToType && !in_array($type, $restrictToType)) {
                continue;

            } elseif(null !== $excludeType && in_array($type, $excludeType)) {
                continue;
            }

            foreach($items as $index => $item) {
                if($item->respondsTo($name)) {
                    return $item;
                }
            }
        }
        $type = null;
        $index = null;
        return null;
    }

    public function getTypes(): array {
        return array_keys($this->items);
    }

    public function getItems(): array {
        return $this->items;
    }

    public function getItemsByType(string $type): array {
        return $this->items[$type] ?? [];
    }

    public function getItemByIndex(string $type, int $index): ?AbstractInputType {
        return $this->items[$type][$index] ?? null;
    }

    public static function merge(self ...$collections): self
    {
        $items = [];

        foreach ($collections as $c) {
            foreach($c->items() as $type => $items) {
                foreach($items as $item) {
                    $items[] = $item;
                }
            }
        }

        $mergedCollection = new self();

        foreach ($items as $input) {
            try {
                $mergedCollection->append($input, true);
            } catch (\Exception $ex) {
                // Already exists, so skip it.
            }
        }

        return $mergedCollection;
    }
}
