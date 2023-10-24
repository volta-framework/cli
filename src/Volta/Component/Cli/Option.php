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


class Option
{

    /**
     * @param string $shortName
     * @param string $longName
     * @param EnumOptionType $type
     * @param string $description
     * @throws Exception
     */
    public function __construct(
        public readonly string $shortName,
        public readonly string $longName,
        public readonly EnumOptionType $type,
        public readonly string $description
    ){
        if ($shortName !== '') {
            if (!preg_match('/^[a-zA-Z]{1}$/', $shortName, $matches)) {
                throw new Exception(sprintf('Short option must be exactly one character(a-z, A-Z) long, %d given.', strlen($shortName)));
            }
        }
        if ($longName !== '') {
            if (!preg_match('/^[a-zA-Z]{2,16}$/', $this->longName, $matches)) {
                throw new Exception(sprintf('Long option must be exactly between 2 and 16 character(a-z, A-Z) long, %d given.', strlen($this->longName)));
            }
        }
        if ($shortName === '' && $longName === '') {
            throw new Exception('Both short name and long name are empty');
        }
    }

}