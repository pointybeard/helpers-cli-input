<?php

declare(strict_types=1);
include __DIR__.'/../vendor/autoload.php';

use pointybeard\Helpers\Cli\Input;
use pointybeard\Helpers\Cli\Colour\Colour;
use pointybeard\Helpers\Functions\Flags;
use pointybeard\Helpers\Functions\Strings;
use pointybeard\Helpers\Functions\Cli;

// Define what we are expecting to get from the command line
$collection = (new Input\InputCollection())
    ->append(new Input\Types\Argument(
        'action',
        Input\AbstractInputType::FLAG_REQUIRED,
        'The name of the action to perform'
    ))
    ->append(new Input\Types\Option(
        'v',
        null,
        Input\AbstractInputType::FLAG_OPTIONAL | Input\AbstractInputType::FLAG_TYPE_INCREMENTING,
        'verbosity level. -v (errors only), -vv (warnings and errors), -vvv (everything).',
        null,
        0
    ))
    ->append(new Input\Types\Option(
        'd',
        'data',
        Input\AbstractInputType::FLAG_OPTIONAL | Input\AbstractInputType::FLAG_VALUE_REQUIRED,
        'Path to the input JSON data',
        function (Input\AbstractInputType $input, Input\AbstractInputHandler $context) {
            // Make sure -d (--data) is a valid file that can be read
            $file = $context->getOption('d');

            if (!is_readable($file)) {
                throw new \Exception('The file specified via option -d (--data) does not exist or is not readable.');
            }

            // Now make sure it is valid JSON
            try {
                $json = json_decode(file_get_contents($file), false, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException $ex) {
                throw new \Exception(sprintf('The file specified via option -d (--data) does not appear to be a valid JSON ddocument. Returned: %s: %s', $ex->getCode(), $ex->getMessage()));
            }

            return $json;
        }
    ))
;

// Get the supplied input. Passing the collection will make the handler bind values
// and validate the input according to our collection
$argv = Input\InputHandlerFactory::build('Argv', $collection);

// Display the manual in green text
echo Colour::colourise(Cli\manpage(
    basename(__FILE__),
    '1.0.1',
    'An example script for the PHP Helpers: Command-line Input and Input Type Handlers composer library (pointybeard/helpers-cli-input).',
    'php -f example/example.php -- -vvv -d example/example.json import',
    $collection
), Colour::FG_GREEN) . PHP_EOL . PHP_EOL;

// example.php 1.0.0, An example script for the PHP Helpers: Command-line Input and Input Type Handlers
// composer library (pointybeard/helpers-cli-input).
// Usage: example.php [OPTIONS]... ACTION...
//
// Mandatory values for long options are mandatory for short options too.
//
// Arguments:
//   ACTION              The name of the action to perform
//
// Options:
//   -v                                  verbosity level. -v (errors only), -vv (warnings
//                                       and errors), -vvv (everything).
//   -d, --data=VALUE                    Path to the input JSON data
//
// Examples:
//   php -f example/example.php -- -vvv -d example/example.json import

var_dump($argv->getArgument('action'));
// string(6) "import"

var_dump($argv->getOption('v'));
//int(3)

var_dump($argv->getOption('s'));
//bool(true)

var_dump($argv->getOption('d'));
// class stdClass#11 (1) {
//   public $fruit =>
//   array(2) {
//     [0] =>
//     string(5) "apple"
//     [1] =>
//     string(6) "banana"
//   }
// }
