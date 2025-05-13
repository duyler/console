<?php

declare(strict_types=1);

namespace Duyler\Console;

use UnitEnum;

readonly class CommandConfig
{
    public function __construct(
        /** @var array<string, string|UnitEnum> */
        public array $commands = [],
    ) {}
}
