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
use Volta\Component\Cli\Output;

require_once __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

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

