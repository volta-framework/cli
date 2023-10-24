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

/**
 * Enumeration for the most used box drawing characters.
 *
 * @see https://en.wikipedia.org/wiki/Box-drawing_character
 */
enum EnumBoxChars: int
{

    /*
     * TODO: create a case for each value mentioned in the table in the wiki page
     *

    case LIGHT_TRIPLE_DASH_HORIZONTAL    = 0x2504; // ┄
    case HEAVY_TRIPLE_DASH_HORIZONTAL    = 0x2505; // ┅
    case LIGHT_TRIPLE_DASH_VERTICAL      = 0x2506; // ┆
    case HEAVY_TRIPLE_DASH_VERTICAL      = 0x2507; // ┇
    case LIGHT_QUADRUPLE_DASH_HORIZONTAL = 0x2508; // ┈
    case HEAVY_QUADRUPLE_DASH_HORIZONTAL = 0x2509; // ┉
    case LIGHT_QUADRUPLE_DASH_VERTICAL   = 0x250a; // ┊
    case HEAVY_QUADRUPLE_DASH_VERTICAL   = 0x250b; // ┋
    case LIGHT_DOWN_AND_RIGHT            = 0x250c; // ┌
    case DOWN_LIGHT_AND_RIGHT_HEAVY      = 0x250d; // ┍
    case DOWN_HEAVY_AND_RIGHT_LIGHT      = 0x250e; // ┎
    case HEAVY_DOWN_AND_RIGHT            = 0x250f; // ┏
    */

    case CORNER_UPPER_LEFT = 0x250c; // ┌
    case CORNER_UPPER_LEFT_BOLD = 0x250f; // ┏
    case CORNER_UPPER_RIGHT = 0x2510;
    case CORNER_UPPER_RIGHT_BOLD = 0x2511;

    case CORNER_BOTTOM_LEFT = 0x2514;
    case CORNER_BOTTOM_LEFT_BOLD = 0x2517;
    case CORNER_BOTTOM_RIGHT = 0x2518 ;
    case CORNER_BOTTOM_RIGHT_BOLD = 0x2513;

    case LINE_HOR = 0x2500;  // ─
    case LINE_HOR_DOWN = 0x252c;
    case LINE_HOR_UP = 0x2534;
    case LINE_HOR_BOLD = 0x2501;  // ━
    case LINE_HOR_DOTTED = 0x2504;
    case LINE_HOR_DOTTED_BOLD = 0x2505;

    case LINE_VERT = 0x2502; // │
    case LINE_VERT_RIGHT = 0x251c;
    case LINE_VERT_LEFT = 0x2524;
    case LINE_VERT_HOR = 0x253c;
    case LINE_VERT_BOLD = 0x2503; // ┃
    case LINE_VERT_DOTTED= 0x250a;
    case LINE_VERT_DOTTED_BOLD= 0x250b;

    /**
     * Returns the string character of the Case instance
     * @return string
     */
    public function toChar(): string
    {
        return mb_chr($this->value);
    }

}
