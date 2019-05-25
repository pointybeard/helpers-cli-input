<?php

declare(strict_types=1);

namespace pointybeard\Helpers\Cli\Input;

use pointybeard\Helpers\Functions\Flags;

abstract class AbstractInputHandler implements Interfaces\InputHandlerInterface
{
    protected $input = [];
    protected $collection = null;

    abstract protected function parse(): bool;

    public function bind(InputCollection $inputCollection, bool $skipValidation = false): bool
    {
        // Do the binding stuff here
        $this->input = [];
        $this->collection = $inputCollection;

        $this->parse();

        if (true !== $skipValidation) {
            $this->validate();
        }

        return true;
    }

    private static function checkRequiredAndRequiredValue(AbstractInputType $input, array $context): void
    {
        if (!isset($context[$input->name()])) {
            if (Flags\is_flag_set($input->flags(), AbstractInputType::FLAG_REQUIRED)) {
                throw new Exceptions\RequiredInputMissingException($input);
            }
        } elseif (Flags\is_flag_set($input->flags(), AbstractInputType::FLAG_VALUE_REQUIRED) && (null == $context[$input->name()] || true === $context[$input->name()])) {
            throw new Exceptions\RequiredInputMissingValueException($input);
        }
    }

    public function validate(): void
    {
        foreach ($this->collection->getItems() as $type => $items) {
            foreach($items as $input) {
                self::checkRequiredAndRequiredValue($input, $this->input);

                // There is a default value, input has not been set, and there
                // is no validator
                if(
                    null !== $input->default() &&
                    null === $this->find($input->name()) &&
                    null === $input->validator()
                ) {
                    $result = $input->default();

                // Input has been set and it has a validator
                } elseif(null !== $this->find($input->name()) && null !== $input->validator()) {
                    $validator = $input->validator();

                    if ($validator instanceof \Closure) {
                        $validator = new Validator($validator);
                    } elseif (!($validator instanceof Validator)) {
                        throw new \Exception("Validator for '{$input->name()}' must be NULL or an instance of either Closure or Input\Validator.");
                    }

                    try {
                        $result = $validator->validate($input, $this);
                    } catch(\Exception $ex) {
                        throw new Exceptions\InputValidationFailedException($input, 0, $ex);
                    }

                // No default, no validator, but may or may not have been set
                } else {
                    $result = $this->find($input->name());
                }

                $this->input[$input->name()] = $result;
            }
        }
    }

    public function find(string $name)
    {
        if(isset($this->input[$name])) {
            return $this->input[$name];
        }

        // Check the collection to see if anything responds to $name
        foreach($this->collection->getItems() as $type => $items) {
            foreach($items as $ii) {
                if($ii->respondsTo($name) && isset($this->input[$ii->name()])) {
                    return $this->input[$ii->name()];
                }
            }
        }

        return null;
    }

    public function getInput(): array
    {
        return $this->input;
    }

    public function getCollection(): ?InputCollection
    {
        return $this->collection;
    }
}
