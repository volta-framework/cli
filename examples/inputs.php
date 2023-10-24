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

use Volta\Component\Cli\Input;
use Volta\Component\Cli\Output;
use Volta\Component\Cli\Settings;

require_once __DIR__ . '/../vendor/autoload.php';

Settings::setDefaults();

Input::continue();
Output::writeLn('thanks');
Output::writeLn('You entered ' . Input::pattern('give me a dutch zip code(4 digits, a space and two upper case characters) ? ', '/^[0-9]{4}\s[A-Z]{2}$/'));
Output::writeLn('You entered ' . Input::integer('give me a integer? '));
Output::writeLn('You entered ' . Input::float('give me a float? '));
