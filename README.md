# Volta\Component\Cli

## Features
* Static Helpers for simple PHP CLI scripts
* Methods for markup and formating output
* Wrapper for getops()


## Examples
### `format.php`
```php
<?php
/*
 * This file is part of the Volta package.
 *
 * (c) Rob Demmenie <rob@volta-framework.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

use Volta\Component\Cli\EnumFormatCodes;
use Volta\Component\Cli\EnumOptionType;
use Volta\Component\Cli\Option;
use Volta\Component\Cli\Options;
use Volta\Component\Cli\Output;

require_once __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

Options::add(new Option(shortName:'h',longName: 'help',type: EnumOptionType::NO_VALUE, description: 'Outputs this help'));
if (Options::get('help') === true) { Output::help(); exit(); }

Output::clear();


// draw a box
Output::writeLn('<blue_bg>Box: 70 chars width and blue border:</>');
Output::box(
    innerText:'Lorem ipsum dolor sit amet, <bold>consectetur</bold> adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <yellow>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</>. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
    width:70,
    color: EnumFormatCodes::BLUE
);
Output::writeLn();
Output::error('An bogus error');
Output::writeLn();
Output::writeLn('<blue_bg>Line: Magenta 50 chars:</>');
Output::line(50, EnumFormatCodes::MAGENTA);
Output::writeLn();
Output::writeLn('<blue_bg>List</>');
Output::list([
    'one' => 'six',
    'two' => 'zeven',
    'three' => 'eight',
    'four' => 'nine',
    'five' => 'ten',
]);
Output::writeLn();
Output::writeLn('<blue_bg>Output::table()</>');
Output::table(
    headers:['number', 'number'],
    data: [
        ['one', 'two'],
        ['three', 'four'],
        ['five', 'six'],
        ['seven', 'eight'],
        ['nine', 'ten'],
    ]
);
````

### `markup.php`
```php
<?php
/*
 * This file is part of the Volta package.
 *
 * (c) Rob Demmenie <rob@volta-framework.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

use Volta\Component\Cli\EnumFormatCodes;
use Volta\Component\Cli\EnumOptionType;
use Volta\Component\Cli\Option;
use Volta\Component\Cli\Options;
use Volta\Component\Cli\Output;

require_once __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

Options::add(new Option(shortName:'h',longName: 'help',type: EnumOptionType::NO_VALUE, description: 'Outputs this help'));
if (Options::get('help') === true) { Output::help(); exit(); }
Output::clear();


foreach(EnumFormatCodes::cases() as $formatCode) {
    Output::writeln('<' . strtolower($formatCode->name). '>Hello World [EnumFormatCodes::' . $formatCode->name . ']</>');
}

```

### `examples/options.php`
```php
<?php
/*
 * This file is part of the Volta package.
 *
 * (c) Rob Demmenie <rob@volta-framework.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

use Volta\Component\Cli\EnumFormatCodes;
use Volta\Component\Cli\EnumOptionType;
use Volta\Component\Cli\Option;
use Volta\Component\Cli\Output;
use Volta\Component\Cli\Options;

require_once __DIR__ . '/../vendor/autoload.php';


Options::add(new Option('h', 'help', EnumOptionType::NO_VALUE,  'Outputs this help'));
Options::add(new Option('a', 'aaaaa', EnumOptionType::OPTIONAL_VALUE, 'The option -a may have a value'));
Options::add(new Option('b', '',type: EnumOptionType::REQUIRE_VALUE, 'The option -b must have a value'));
Options::add(new Option('c', '',type: EnumOptionType::NO_VALUE, 'The option -c must have no value'));
Options::add(new Option('', 'ddddd', EnumOptionType::NO_VALUE, 'The option -d must have no value'));

if (Options::get('help') === true) { Output::help(); exit(); }

```
