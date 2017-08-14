# Simple Options Parser

SimpleOptionsParser is a command-line options parser for PHP. It has no bells and whistles like others before it. No default help messages, no requirements checking, just simple, quick parsing.

## Usage

First create a parser object and then use it to parse your arguments:

```php
$parser = new SimpleOptionsParser();
$result = $parser->parse();

// quick 'n' easy way to pull commands and options from the results:
extract((new SimpleOptionsParser)->parse());
// now $commands and $opts will be available in the local scope
```
