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

foreach(EnumFormatCodes::cases() as $formatCode) {
    Output::writeln('<' . strtolower($formatCode->name). '>Hello World [EnumFormatCodes::' . $formatCode->name . ']</>');
}
