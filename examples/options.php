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


Options::add(new Option(shortName:'h',longName: 'help',type: EnumOptionType::NO_VALUE, description: 'Outputs this help'));
Options::add(new Option(shortName:'a',longName: 'aaaaa',type: EnumOptionType::OPTIONAL_VALUE, description: 'The option -a may have a value'));
Options::add(new Option(shortName:'b',longName: '',type: EnumOptionType::REQUIRE_VALUE, description: 'The option -b must have a value'));
Options::add(new Option(shortName:'c',longName: '',type: EnumOptionType::NO_VALUE, description: 'The option -c must have no value'));
Options::add(new Option(shortName:'',longName: 'ddddd',type: EnumOptionType::NO_VALUE, description: 'The option -d must have no value'));

if (Options::get('help') === true) { Output::help(); exit(); }

