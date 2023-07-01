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

use Volta\Component\Cli\EnumOptionType;
use Volta\Component\Cli\Option;
use Volta\Component\Cli\Output;
use Volta\Component\Cli\Options;

require_once __DIR__ . '/../vendor/autoload.php';


Output::setDefaults();

Options::add(new Option('a', 'aaaaa', EnumOptionType::OPTIONAL_VALUE, 'The option -a may have a value'));
Options::add(new Option('b', '',EnumOptionType::REQUIRE_VALUE, 'The option -b must have a value'));
Options::add(new Option('c', '',EnumOptionType::NO_VALUE, 'The option -c must have no value'));
Options::add(new Option('', 'ddddd', EnumOptionType::NO_VALUE, 'The option -d must have no value'));

