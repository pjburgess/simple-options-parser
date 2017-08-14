# Simple Options Parser

OptionParser is a command-line options parser for PHP. It has no bells and whistles like others before it. No default help messages, no requirements checking, just simple, quick parsing.

## Usage

First create a parser object and then use it to parse your arguments:

```php
$parser = new OptionsParser();
$result = $parser->parse();

// quick 'n' easy way to pull $commands and $opts from the results:
extract((new OptionsParser)->parse());
```
