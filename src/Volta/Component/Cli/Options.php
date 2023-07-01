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

    public static function getResult(): array
    {
        if (Options::$_result === null) options::parse();
        return Options::$_result;
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
     * @param string|null $default
     * @return string|bool The value (string) or TRUE when there is no value but is passed, FALSE when not passed
     * @throws Exception
     */
    public static function get(string $name, string|null $default = null): string|bool
    {
        if (Options::$_result === null) Options::parse();
        foreach(Options::$_options as $option) {
            if ($option->shortName === $name || $option->longName === $name) {
                $index = null;
                if (isset(Options::$_result[$option->shortName])) $index = $option->shortName;
                if (isset(Options::$_result[$option->longName])) $index = $option->longName;
                if ($index === null) {

                    // not provided but a value can/must be given and a default value is provided return the default
                    if ($option->type === EnumOptionType::REQUIRE_VALUE && is_string($default)) return $default;
                    if ($option->type === EnumOptionType::OPTIONAL_VALUE && is_string($default)) return $default;

                    // in all cases return false(option not provided)
                    return false;
                }

                // present but no value given
                if (false === Options::$_result[$index]) return true;

                // present and a value is given, return the value
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
    public static function parse(): array|false
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