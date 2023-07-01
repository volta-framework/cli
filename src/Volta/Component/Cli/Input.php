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

abstract class Input
{

    /**
     * @param string $prompt
     * @param string $abortPattern
     * @return bool
     */
    public static function continue(string $prompt = 'Do you want to continue? [yep = *, nope = n] : ', string $abortPattern = '/^n$/'): bool
    {
        Output::write("<italic>$prompt</italic>");
        $userInput = trim(fgets(STDIN));
        return !preg_match($abortPattern, $userInput);
    }

    /**
     * @param string $prompt
     * @param string $pattern
     * @param string $errorPrompt
     * @return string
     */
    public static function pattern(string $prompt, string $pattern = '/^.*$/', string $errorPrompt = 'This is not a valid, please try again.'): string
    {
        do {
            Output::write("<italic>$prompt</italic>");
            $userInput = trim(fgets(STDIN));
            $valid = preg_match($pattern, $userInput, $matches);
        } while (!$valid);
        return $userInput;
    }

    /**
     * @param string $prompt
     * @param int $min
     * @param int $max
     * @param string $errorPrompt
     * @return int
     */
    public static function integer(string $prompt, int $min = PHP_INT_MIN, int $max = PHP_INT_MAX, string $errorPrompt = 'This is not a valid, please try again.'): int
    {
        do {
            Output::write("<italic>$prompt</italic>");
            $userInput = trim(fgets(STDIN));
            $valid = filter_var($userInput,FILTER_VALIDATE_INT, ['options' => ['min_range' => $min,'max_range' => $max]]);
            if (!$valid) Output::writeLn($errorPrompt);
        } while(!$valid);
        return (int) $userInput;
    }

    /**
     * @param string $prompt
     * @param float $min
     * @param float $max
     * @param string $errorPrompt
     * @return float
     */
    public static function float(string $prompt, float $min = PHP_FLOAT_MIN, float $max = PHP_FLOAT_MAX, string $errorPrompt = 'This is not a valid , please try again.'): float
    {
        do {
            Output::write("<italic>$prompt</italic>");
            $userInput = trim(fgets(STDIN));
            $valid = filter_var($userInput,FILTER_VALIDATE_FLOAT, ['options' => ['min_range' => $min, 'max_range' => $max]]);
            if (!$valid) Output::writeLn($errorPrompt);
        } while(!$valid);
        return (float) $userInput;
    }

}