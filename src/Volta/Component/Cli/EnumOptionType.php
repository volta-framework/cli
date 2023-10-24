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
 * Possible types for a getopt() option
 */
enum EnumOptionType
{
    case NO_VALUE;
    case REQUIRE_VALUE;
    case OPTIONAL_VALUE;

}
