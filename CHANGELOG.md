# Change Log

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

**View all [Unreleased][] changes here**

## [1.1.1][]
#### Changed
-   `AbstractInputHandler::find()` returns NULL if it cannot find any input with the supplied name. It is easier to test for NULL than it is to catch an exception.

## [1.1.0][]
#### Added
-   Expanded input types to include `Flag`, `IncrementingFlag`, and `LongOption`.
-   Added `InputTypeFactory` to help with loading input type classes

#### Changed
-   Updated to work with more than just `Argument` and `Option` input types. Makes use of `InputTypeFactory` to allow addition of new types as needed.

## [1.0.2][]
#### Changed
-   Updated example to reflect changes to `manpage()` function in `pointybeard/helpers-functions-cli` package
-   Refactoring and improvemnts to `Argument::__toString()` and `Option::__toString()`

## [1.0.2][]
#### Fixed
-   Fixed `InputCollection::getArgumentsByIndex()` so it returns NULL if the index does not exist instead of throwing an E_NOTICE message

## [1.0.1][]
#### Changed
-   Updated example to use `Cli\manpage()` provided by the `pointybeard/helpers-functions-cli` package

## 1.0.0
#### Added
-   Initial release

[Unreleased]: https://github.com/pointybeard/helpers-functions-cli/compare/1.1.1...integration
[1.1.1]: https://github.com/pointybeard/helpers-functions-cli/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/pointybeard/helpers-functions-cli/compare/1.0.3...1.1.0
[1.0.3]: https://github.com/pointybeard/helpers-functions-cli/compare/1.0.2...1.0.3
[1.0.2]: https://github.com/pointybeard/helpers-functions-cli/compare/1.0.1...1.0.2
[1.0.1]: https://github.com/pointybeard/helpers-functions-cli/compare/1.0.0...1.0.1
