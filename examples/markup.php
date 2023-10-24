<?php
/*
 * This file is part of the Volta package.
 *
 * (c) Rob Demmenie <rob@volta-server-framework.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

use Volta\Component\Cli\EnumFormatCodes;
use Volta\Component\Cli\Output;
use Volta\Component\Cli\Settings;

require_once __DIR__ . '/../vendor/autoload.php';

Settings::setDefaults();

foreach(EnumFormatCodes::cases() as $formatCode) {
    Output::writeln('<' . strtolower($formatCode->name). '>Hello World [EnumFormatCodes::' . $formatCode->name . ']</>');
}
