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
 * Class to write to the console.
 *
 * Internally the STDOUT stream is used bypassing the PHP buffering which is used with
 * echo or print.
 *
 * ```php
 *
 *   Output::write("hello world");
 *
 * ```
 */
class Output
{

    #region - Formatting text



    /**
     * List with all possible tags
     * @return array<string, string>
     */
    public static function getPlaceholders(): array
    {
        return [
            '</>' => EnumFormatCodes::CLEAR->value,
            '<clear>' => EnumFormatCodes::CLEAR->value,
            '<b>' => EnumFormatCodes::BOLD->value,          '</b>' => EnumFormatCodes::CLEAR->value,
            '<bold>' => EnumFormatCodes::BOLD->value,       '</bold>' => EnumFormatCodes::CLEAR->value,
            '<i>' => EnumFormatCodes::ITALIC->value,        '</i>' => EnumFormatCodes::CLEAR->value,
            '<italic>' => EnumFormatCodes::ITALIC->value,        '</italic>' => EnumFormatCodes::CLEAR->value,
            '<u>' => EnumFormatCodes::UNDERLINE->value,     '</u>' => EnumFormatCodes::CLEAR->value,
            '<underline>' => EnumFormatCodes::UNDERLINE->value,     '</underline>' => EnumFormatCodes::CLEAR->value,
            '<r>' => EnumFormatCodes::REVERSED->value,     '</r>' => EnumFormatCodes::CLEAR->value,
            '<reversed>' => EnumFormatCodes::REVERSED->value,     '</reversed>' => EnumFormatCodes::CLEAR->value,
            '<s>' => EnumFormatCodes::STRIKETHROUGH->value, '</s>' => EnumFormatCodes::CLEAR->value,
            '<strikethrough>' => EnumFormatCodes::STRIKETHROUGH->value, '</strikethrough>' => EnumFormatCodes::CLEAR->value,
            '<black>' => EnumFormatCodes::BLACK->value, '</black>' => EnumFormatCodes::FOREGROUND->value,
            '<foreground>' => EnumFormatCodes::BLACK->value, '</foreground>' => EnumFormatCodes::FOREGROUND->value,
            '<red>' => EnumFormatCodes::RED->value, '</red>' => EnumFormatCodes::FOREGROUND->value,
            '<green>' => EnumFormatCodes::GREEN->value, '</green>' => EnumFormatCodes::FOREGROUND->value,
            '<yellow>' => EnumFormatCodes::YELLOW->value, '</yellow>' => EnumFormatCodes::FOREGROUND->value,
            '<blue>' => EnumFormatCodes::BLUE->value, '</blue>' => EnumFormatCodes::FOREGROUND->value,
            '<magenta>' => EnumFormatCodes::MAGENTA->value, '</magenta>' => EnumFormatCodes::FOREGROUND->value,
            '<cyan>' => EnumFormatCodes::CYAN->value, '</cyan>' => EnumFormatCodes::FOREGROUND->value,
            '<gray>' => EnumFormatCodes::GRAY->value, '</gray>' => EnumFormatCodes::FOREGROUND->value,
            '<bg>' => EnumFormatCodes::BLACK_BG->value, '</bg>' => EnumFormatCodes::CLEAR->value,
            '<background>' => EnumFormatCodes::BLACK_BG->value, '</bg>' => EnumFormatCodes::CLEAR->value,
            '<black_bg>' => EnumFormatCodes::BLACK_BG->value, '</blackbg>' => EnumFormatCodes::BACKGROUND->value,
            '<red_bg>' => EnumFormatCodes::RED_BG->value, '</redbg>' => EnumFormatCodes::BACKGROUND->value,
            '<green_bg>' =>EnumFormatCodes::GREEN_BG->value, '</greenbg>' => EnumFormatCodes::BACKGROUND->value,
            '<yellow_bg>' => EnumFormatCodes::YELLOW_BG->value, '</yellowbg>' => EnumFormatCodes::BACKGROUND->value,
            '<blue_bg>' => EnumFormatCodes::BLUE_BG->value, '</bluebg>' => EnumFormatCodes::BACKGROUND->value,
            '<magenta_bg>' => EnumFormatCodes::MAGENTA_BG->value, '</magentabg>' => EnumFormatCodes::BACKGROUND->value,
            '<cyan_bg>' => EnumFormatCodes::CYAN_BG->value, '</cyanbg>' => EnumFormatCodes::BACKGROUND->value,
            '<gray_bg>' => EnumFormatCodes::GRAY_BG->value, '</graybg>' => EnumFormatCodes::BACKGROUND->value,
            '<light_gray>' => EnumFormatCodes::LIGHT_GRAY->value, '</lightgray>' => EnumFormatCodes::FOREGROUND->value,
            '<light_red>' => EnumFormatCodes::LIGHT_RED->value, '</lightred>' => EnumFormatCodes::FOREGROUND->value,
            '<light_green>' => EnumFormatCodes::LIGHT_GREEN->value, '</lightgreen>' => EnumFormatCodes::FOREGROUND->value,
            '<light_yellow>' => EnumFormatCodes::LIGHT_YELLOW->value, '</lightyellow>' => EnumFormatCodes::FOREGROUND->value,
            '<light_blue>' => EnumFormatCodes::LIGHT_BLUE->value, '</lightblue>' => EnumFormatCodes::FOREGROUND->value,
            '<light_magenta>' => EnumFormatCodes::LIGHT_MAGENTA->value, '</lightmagenta>' => EnumFormatCodes::FOREGROUND->value,
            '<light_cyan>' => EnumFormatCodes::LIGHT_CYAN->value, '</lightcyan>' => EnumFormatCodes::FOREGROUND->value,
            '<white>' => EnumFormatCodes::WHITE->value, '</white>' => EnumFormatCodes::FOREGROUND->value,
        ];
    }

    /**
     * Formats the given string
     * @param string $text Text with format tags
     * @return string The formatted string
     */
    public static function format(string $text): string
    {
        $placeholders = static::getPlaceholders();
        return str_replace(array_keys($placeholders), $placeholders, $text);
    }

    #endregion

    #region - Creating a Box with content

    /**
     * Draws a box surrounding the given text.
     * The content is broken up in multiple lines to fit the width of the box.
     *
     * @param string|array<string> $innerText Array with lines or text to be printed in the box
     * @param int $width The width of the box in characters
     * @param EnumFormatCodes $color The color of the lines
     * @return void
     */
    public static function box(string|array $innerText, int $width = 80, EnumFormatCodes $color = EnumFormatCodes::FOREGROUND): void
    {
        static::boxTop($width, $color);

        if(is_string($innerText)) {
            $innerText = explode("\n", wordwrap($innerText, $width-4));
        }
        foreach($innerText as $line) {
            static::boxLine($line, $width, $color);
        }

        static::boxBottom($width, $color);
    }


    /**
     * Prints the top of a box
     * @see Output::box()
     * @param int $width
     * @param EnumFormatCodes $color
     * @return void
     */
    public static function boxTop(int $width=80, EnumFormatCodes $color = EnumFormatCodes::FOREGROUND): void
    {
        static::writeLn(
            $color->value .
            EnumBoxChars::CORNER_UPPER_LEFT->toChar() .
            str_repeat(EnumBoxChars::LINE_HOR->toChar() , $width - 2) .
            EnumBoxChars::CORNER_UPPER_RIGHT->toChar(). EnumFormatCodes::CLEAR->value
        );
    }

    /**
     * Prints a middle section with or without content.
     * @see Output::box()
     * @param string $innerText
     * @param int $width
     * @param EnumFormatCodes $color
     * @return void
     */
    public static function boxLine(string $innerText, int $width = 80, EnumFormatCodes $color = EnumFormatCodes::FOREGROUND): void
    {
        $stripped = strip_tags($innerText);
        $pad = $width - 3 - strlen($stripped);

        static::write($color->value . EnumBoxChars::LINE_VERT->toChar(). EnumFormatCodes::CLEAR->value);
        static::write(' ' . static::format($innerText) . str_repeat(' ', $pad));
        static::write($color->value . EnumBoxChars::LINE_VERT->toChar(). EnumFormatCodes::CLEAR->value);
        static::write("\n");
    }

    /**
     * Prints the bottom of a box
     * @see Output::box()
     * @param int $width
     * @param EnumFormatCodes $color
     * @return void
     */
    public static function boxBottom(int $width=80, EnumFormatCodes $color = EnumFormatCodes::FOREGROUND): void
    {
        static::write(
            $color->value .EnumBoxChars::CORNER_BOTTOM_LEFT->toChar() .
            str_repeat(EnumBoxChars::LINE_HOR->toChar() , $width - 2) .
            EnumBoxChars::CORNER_BOTTOM_RIGHT->toChar() . EnumFormatCodes::CLEAR->value . "\n"
        );
    }

    #endregion

    #region - Error

    /**
     * Prints the error in red
     *
     * @param string $text
     * @return void
     */
    public static function error(string $text): void
    {
        fwrite(STDERR, Output::format(
            "\n\n\t<red><b>$text</red><b></red>\n\n"));
    }

    /**
     * @param int $code
     * @param string $message
     * @param string $file
     * @param int $line
     * @param array $context
     * @return bool
     */
    public static function errorHandler(int $code, string $message, string $file = '', int $line = 0, array $context = []): bool
    {
        Output::writeLn();
        Output::line(120);
        Output::writeLn('<bold>' . str_pad(' code', 8) . '</bold> : ' . $code);
        Output::writeLn('<bold>' . str_pad(' message', 8) . '</bold> : ' . $message);
        Output::writeLn('<bold>' . str_pad(' file', 8) . '</bold> : ' . $file);
        Output::writeLn('<bold>' . str_pad(' line', 8) . '</bold> : ' . $line);
        Output::line(120);
        Output::writeLn();
        return true;
    }

    /**
     * @param \Throwable $exception
     * @return bool
     */
    public static function exceptionHandler(\Throwable $exception): bool
    {
        Output::writeLn();
        Output::line(120);
        Output::writeLn('<bold>' . str_pad(' code', 8) . '</bold> : ' . $exception->getCode());
        Output::writeLn('<bold>' . str_pad(' message', 8) . '</bold> : ' . $exception->getMessage());
        Output::writeLn('<bold>' . str_pad(' file', 8) . '</bold> : ' . $exception->getFile());
        Output::writeLn('<bold>' . str_pad(' line', 8) . '</bold> : ' . $exception->getLine());
        Output::line(120);
        Output::writeLn();
        return true;
    }

    #endregion

    #region - Writing

    /**
     * Formats and writes text to the STDOUT stream with no line break
     * @param mixed $text
     * @return void
     */
    public static function write(mixed $text): void {
        fwrite(STDOUT, Output::format((string)$text));
    }

    /**
     * Formats and writes text to the STDOUT stream with a line break
     * @param mixed $text
     * @return void
     */
    public static function writeLn(mixed $text=''): void
    {
        static::write($text .  EnumFormatCodes::CLEAR->value . "\n");
    }

    /**
     * Prints a line with specified width, color and background color
     *
     * @param int $width
     * @param EnumFormatCodes $color
     * @return void
     */
    public static function line(int $width = 80, EnumFormatCodes $color = EnumFormatCodes::FOREGROUND): void
    {
        static::writeLn(
            $color->value.str_repeat(EnumBoxChars::LINE_HOR->toChar(), $width) . EnumFormatCodes::CLEAR->value
        );
    }

    #endregion

    #region - Key/Value pairs

    /**
     * Formats an associated array as key-value pairs
     *
     * @param array<string> $list
     * @return void
     */
    public static function list(array $list): void
    {
        foreach($list as $key => $val) {
            static::keyValue((string) $key, $val);
        }
    }

    /**
     * The color setting for the key in a key-value pair.
     *
     * @var EnumFormatCodes
     */
    public static EnumFormatCodes $keyColor = EnumFormatCodes::YELLOW;

    /**
     * The width setting for the key in a key-value pair.
     *
     * @var int
     */
    public static int $keyWidth = 32;

    /**
     * The color setting for the value in a key-value pair.
     *
     * @var EnumFormatCodes
     */
    public static EnumFormatCodes $valueColor = EnumFormatCodes::GREEN;

    /**
     * Formats a key-value pair
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function keyValue(string $key, mixed $value) : void
    {
        $strippedKey = strip_tags($key);
        $pad = static::$keyWidth - strlen($strippedKey);

        if ($strippedKey === $key) {
            $key = static::$keyColor->value . EnumFormatCodes::BOLD->value  . $key . EnumFormatCodes::CLEAR->value;
            $pad = static::$keyWidth - strlen($strippedKey);
        }

        if (is_string($value)) {
            $strippedValue = strip_tags($value);
            if ($strippedValue === $value) {
                $value = static::$valueColor->value . $value . EnumFormatCodes::CLEAR->value;
            }
        } else {
            $value =  static::$valueColor->value . $value . EnumFormatCodes::CLEAR->value;
        }

        static::writeLn(
            static::format($key) . str_repeat(' ', $pad) . ': ' . static::format($value)
        );
    }

    #endregion

    /**
     * Clears the screen
     *
     * @return void
     */
    public static function clear(): void
    {
        fwrite(STDOUT, "\e[2J");
        static::cursorTo(0, 0);        
        //DIRECTORY_SEPARATOR === '\\' ? popen('cls', 'w') : exec('clear');
    }

    /**
     * Shows a progress indicator
     *
     * @param int $percentage
     * @return void
     */
    public static function progress(int $percentage): void
    { 
        fwrite(STDOUT, "\e[1000D $percentage%");
    }


    /**
     * Moves the cursor the specified steps up
     *
     * @param int $steps
     * @return void
     */
    public static function cursorUp(int $steps):void
    {
        fwrite(STDOUT, "\e{$steps}A");
    }

    /**
     * Moves the cursor the specified steps down
     *
     * @param int $steps
     * @return void
     */
    public static function cursorDown(int $steps):void
    {
        fwrite(STDOUT, "\e{$steps}B");
    }

    /**
     * Moves the cursor the specified steps to the right
     *
     * @param int $steps
     * @return void
     */
    public static function cursorRight(int $steps):void
    {
        fwrite(STDOUT, "\e{$steps}C");
    }

    /**
     * Moves the cursor the specified steps to the left
     *
     * @param int $steps
     * @return void
     */
    public static function cursorLeft(int $steps):void
    {
        fwrite(STDOUT, "\e{$steps}D");
    }

    /**
     * Moves the cursor the specified location
     *
     * @param int $rowOrCol
     * @param int|null $col
     * @return void
     */
    public static function cursorTo(int $rowOrCol, int|null $col=null): void
    {
        if (null === $col) {
            fwrite(STDOUT, "\e[{$rowOrCol}G");
        } else {
            fwrite(STDOUT, "\e[{$rowOrCol};{$col}H");
        }
        
    }

    /**
     * Prints a table
     *
     * @param string[] $headers
     * @param array<array<>> $data
     * @return void
     */
    public static function table(array $headers, array $data): void
    {
        if (!isset($data[0])) exit("\n\tNo data for the table\n");
        if (count($headers) !== count($data[0])) exit("\n\tNumbers headers and data columns does not match\n");

        $columns = array_fill(0, count($headers), 0);
        foreach($headers as $col => $header) {
            if (strlen($header) > $columns[$col]) $columns[$col] = strlen($header);
        }
        foreach($data as $row => $rowData) {
            foreach($rowData as $col=> $val) {
                if (strlen($val) > $columns[$col]) $columns[$col] = strlen($val);
            }
        }

        $top = '';
        foreach($columns as $col => $width) {
            if ($col === 0 ) $top .= EnumBoxChars::CORNER_UPPER_LEFT->toChar();
            $top .= str_repeat(EnumBoxChars::LINE_HOR->toChar(), $width);
            if ($col === count($columns) -1 ) {
                $top .= EnumBoxChars::CORNER_UPPER_RIGHT->toChar();
            }  else {
                $top .= EnumBoxChars::LINE_HOR_DOWN->toChar();
            }
        }
        $top .= "\n";
        fwrite(STDOUT,  $top );

        $head = '';
        foreach($columns as $col => $width) {
            if ($col === 0 ) $head .=  EnumBoxChars::LINE_VERT->toChar();
            $head .= str_pad($headers[$col], $width);
            $head .=  EnumBoxChars::LINE_VERT->toChar();
        }
        $head .= "\n";
        fwrite(STDOUT,  $head );

        $bottomHead = '';
        foreach($columns as $col => $width) {
            if ($col === 0 ) $bottomHead .=  EnumBoxChars::LINE_VERT_RIGHT->toChar();
            $bottomHead .= str_repeat( EnumBoxChars::LINE_HOR->toChar(), $width);
            if ($col === count($columns) -1 ) {
                $bottomHead .=  EnumBoxChars::LINE_VERT_LEFT->toChar();
            }  else {
                $bottomHead .=  EnumBoxChars::LINE_VERT_HOR->toChar();
            }
        }
        $bottomHead .="\n";
        fwrite(STDOUT,  $bottomHead );

        foreach($data as $row => $rowData) {
            $bodyLine = '';
            foreach($columns as $col => $width) {
                if ($col === 0 ) $bodyLine .=  EnumBoxChars::LINE_VERT->toChar();
                $bodyLine .= str_pad($rowData[$col], $width);
                $bodyLine .=  EnumBoxChars::LINE_VERT->toChar();
            }
            $bodyLine .= "\n";
            fwrite(STDOUT,  $bodyLine );
        }

        $bottomBody = '';
        foreach($columns as $col => $width) {
            if ($col === 0 ) $bottomBody .=  EnumBoxChars::CORNER_BOTTOM_LEFT->toChar();
            $bottomBody .= str_repeat( EnumBoxChars::LINE_HOR->toChar(), $width);
            if ($col === count($columns) -1 ) {
                $bottomBody .=  EnumBoxChars::CORNER_BOTTOM_RIGHT->toChar();
            }  else {
                $bottomBody .=  EnumBoxChars::LINE_HOR_UP->toChar();
            }
        }
        $bottomBody .="\n";
        fwrite(STDOUT,  $bottomBody );
    }


    /**
     * @param string $intro
     * @param string $ending
     * @return void
     */
    public static function help(string $intro ='', string $ending=''):void
    {
        $trace = debug_backtrace();

        Output::writeLn();
        Output::writeLn('Use: ~$: php ' . basename($trace[count($trace) -1]['file'] .  ' [OPTIONS]'));
        if(!empty($intro)) Output::writeLn($intro);
        foreach(Options::getOptions() as $option){
            if (!empty($option->shortName)) {
                Output::write(' <yellow>-' . $option->shortName . '</yellow>');
            } else {
                Output::write(str_repeat(' ', 3));
            }
            if (!empty($option->longName)) {
                Output::write((empty($option->shortName) ? '  ': ', ')) ;
                Output::write('<yellow>--' . str_pad($option->longName, 20) . '</yellow>');
            } else {
                Output::write(str_repeat(' ',24));
            }
            Output::write('<yellow>' . match($option->type) {
                    EnumOptionType::NO_VALUE       => '         ',
                    EnumOptionType::OPTIONAL_VALUE => '[=VALUE] ',
                    EnumOptionType::REQUIRE_VALUE  => ' =VALUE  '
                } .  '</yellow>');
            Output::writeLn('<italic>' . $option->description . '</italic>');
        }
        if(!empty($ending))  Output::writeLn($ending);
    }






    // public static function cursorSave(): void
    // {
    //     fwrite(STDOUT, "\e[");
    // }

    // public static function cursorRestore(): void
    // {
    //     fwrite(STDOUT, "\e[");
    // }

}
