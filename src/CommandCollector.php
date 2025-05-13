<?php

declare(strict_types=1);

namespace Duyler\Console;

use InvalidArgumentException;
use UnitEnum;

final class CommandCollector
{
    /** @var array<string, string|UnitEnum> $commands */
    private array $commands = [];

    public function __construct(
        CommandConfig $commandConfig,
    ) {
        $this->commands = $commandConfig->commands;

        foreach ($this->commands as $command => $actionId) {
            $this->validateCommandName($command);
        }
    }

    public function get(string $command): string|UnitEnum
    {
        return $this->commands[$command];
    }

    public function has(string $command): bool
    {
        return isset($this->commands[$command]);
    }

    public function add(string $command, string|UnitEnum $actionId): void
    {
        if (array_key_exists($command, $this->commands)) {
            throw new InvalidArgumentException("Command '$command' already exists.");
        }

        $this->validateCommandName($command);

        $this->commands[$command] = $actionId;
    }

    private function validateCommandName(string $command): void
    {
        if (0 === preg_match('/^(?!.*\s)[a-z]+(:[a-z]+)*$/', $command)) {
            throw new InvalidArgumentException('Name of a command needs to be a valid command name.');
        }
    }
}
