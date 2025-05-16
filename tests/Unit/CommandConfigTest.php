<?php

declare(strict_types=1);

namespace Duyler\Console\Tests\Unit;

use Duyler\Console\CommandConfig;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class CommandConfigTest extends TestCase
{
    #[Test]
    public function it_stores_commands_array(): void
    {
        $commands = ['foo:bar' => 'action_1', 'bar:baz' => 'action_2'];
        $config = new CommandConfig($commands);
        $this->assertSame($commands, $config->commands);
    }

    #[Test]
    public function it_defaults_to_empty_array(): void
    {
        $config = new CommandConfig();
        $this->assertSame([], $config->commands);
    }
}
