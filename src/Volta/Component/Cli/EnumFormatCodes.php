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

namespace Volta\Component\Cli;

enum EnumFormatCodes: string
{
    case CLEAR = "\e[0m";

    case BOLD = "\e[1m";
    case ITALIC = "\e[3m";
    case UNDERLINE = "\e[4m";
    case REVERSED = "\e[7m";
    case STRIKETHROUGH = "\e[9m";


    case BLACK = "\e[30m";
    case RED = "\e[31m";
    case GREEN = "\e[32m";
    case YELLOW = "\e[33m";
    case BLUE = "\e[34m";
    case MAGENTA = "\e[35m";
    case CYAN = "\e[36m";
    case GRAY = "\e[37m";

    /**
     * system foreground color
     */
    case FOREGROUND = "\e[39m";

    case BLACK_BG = "\e[40m";
    case RED_BG = "\e[41m";
    case GREEN_BG = "\e[42m";
    case YELLOW_BG = "\e[43m";
    case BLUE_BG = "\e[44m";
    case MAGENTA_BG = "\e[45m";
    case CYAN_BG = "\e[46m";
    case GRAY_BG = "\e[47m";

    /**
     * system background color
     */
    case BACKGROUND = "\e[49m"; // system background color

    case LIGHT_GRAY = "\e[90m";
    case LIGHT_RED = "\e[91m";
    case LIGHT_GREEN = "\e[92m";
    case LIGHT_YELLOW = "\e[93m";
    case LIGHT_BLUE = "\e[94m";
    case LIGHT_MAGENTA = "\e[95m";
    case LIGHT_CYAN = "\e[96m";

    case WHITE = "\e[97m";


    /**
     * @see https://www.lihaoyi.com/post/BuildyourownCommandLinewithANSIescapecodes.html
     */
     

}

