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

/**
 * Represents an option on the command line
 */
abstract class Options
{


    /**
     * @var Option[]
     */
    protected static array $_options = [];

    /**
     * @var array|false|null 
     */
    protected static null|array|false $_result = null;

    /**
     * If the rest_index parameter is present, then the index where argument parsing stopped will
     * be written to this variable.
     *
     * @see https://www.php.net/manual/en/function.getopt.php
     * @var int|null
     */
    protected static int|null $_restIndex = null;

    /**
     * @param Option $newOption
     * @return void
     * @throws Exception
     */
    public static function add(Option $newOption): void
    {
        foreach(Options::$_options as $option) {
            if (Options::has($newOption->shortName)) {
                throw new Exception('Short option with the same name already exists');
            }
            if (Options::has($newOption->longName)) {
                throw new Exception('Long option with the same name already exists');
            }
        }
        Options::$_options[] = $newOption;
    }

    /**
     * @return Option[]
     */
    public static function getOptions(): array
    {
        return Options::$_options;
    }

    /**
     * @param string $name
     * @return bool TRUE when we have an option with this short- or long-name
     */
    public static function has(string $name): bool
    {
        foreach(Options::$_options as $option) {
            if ($name !== '' &&  ($option->shortName === $name || $option->longName === $name)) {
               return true;
            }
        }
        return false;
    }

    /**
     * @param string $name
     * @return string|bool The value (string) or TRUE when there is no value but is passed, FALSE when not passed
     * @throws Exception
     */
    public static function get(string $name): string|bool
    {
        if (Options::$_result === null) Options::read();
        foreach(Options::$_options as $option) {
            if ($option->shortName === $name || $option->longName === $name) {
                $index = $option->getIndex();
                if (!isset(Options::$_result[$index])) return false;
                if (false === Options::$_result[$index]) return true;
                return Options::$_result[$index];
            }
        }
        return false;
    }

    /**
     * Reads the command line parameters
     *
     * @see https://www.php.net/manual/en/function.getopt.php
     * @return array|false
     * @throws Exception
     */
    public static function read(): array|false
    {
        $shortOptions = '';
        foreach(Options::$_options as $option){
            if (empty($option->shortName)) continue;
            $shortOptions .= $option->shortName;
            $shortOptions .= match($option->type) {
                EnumOptionType::NO_VALUE => '',
                EnumOptionType::OPTIONAL_VALUE => '::',
                EnumOptionType::REQUIRE_VALUE => ':'
            };
        }

        $longOptions = [];
        foreach(Options::$_options as $option){
            if (empty($option->longName)) continue;
            $longOptions[]  = $option->longName . match($option->type) {
                EnumOptionType::NO_VALUE => '',
                EnumOptionType::OPTIONAL_VALUE => '::',
                EnumOptionType::REQUIRE_VALUE => ':'
            };
        }

        Options::$_result = getopt($shortOptions, $longOptions, Options::$_restIndex);

        if(false === Options::$_result) {
            throw new Exception('Reading commandline options failed');
        }

        return Options::$_result;
    }


}