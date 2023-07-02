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

namespace Volta\Component\Cli;

class Settings
{

    /**
     * Adds a help option and sets error and exception handler
     *
     * @param Option[] $options
     * @return void
     * @throws Exception
     */
    public static function initialize(array $options = []): void
    {
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);

        set_error_handler('Volta\Component\Cli\Output::errorHandler');
        set_exception_handler('Volta\Component\Cli\Output::exceptionHandler');

        Options::add(new Option('h', 'help', EnumOptionType::NO_VALUE,  'Outputs this help'));

        foreach($options as $option) {
            Options::add($option);
        }

        if (Options::get('help') === true) {
            Output::help();
            exit();
        }
    }


}