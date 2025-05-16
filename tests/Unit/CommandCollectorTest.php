<?php

declare(strict_types=1);

namespace Duyler\Console\Tests\Unit;

use Duyler\Console\CommandCollector;
use Duyler\Console\CommandConfig;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class CommandCollectorTest extends TestCase
{
    #[Test]
    public function it_returns_action_id_for_existing_command(): void
    {
        $config = new CommandConfig(['foo:bar' => 'action_1']);
        $collector = new CommandCollector($config);
        $this->assertSame('action_1', $collector->get('foo:bar'));
    }

    #[Test]
    public function it_checks_if_command_exists(): void
    {
        $config = new CommandConfig(['foo:bar' => 'action_1']);
        $collector = new CommandCollector($config);
        $this->assertTrue($collector->has('foo:bar'));
        $this->assertFalse($collector->has('not:exists'));
    }

    #[Test]
    public function it_throws_when_adding_duplicate_command(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $config = new CommandConfig(['foo:bar' => 'action_1']);
        $collector = new CommandCollector($config);
        $collector->add('foo:bar', 'action_2');
    }

    #[Test]
    public function it_throws_when_command_name_is_invalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $config = new CommandConfig(['invalid name' => 'action_1']);
        new CommandCollector($config);
    }

    #[Test]
    public function it_adds_new_command(): void
    {
        $config = new CommandConfig(['foo:bar' => 'action_1']);
        $collector = new CommandCollector($config);
        $collector->add('bar:baz', 'action_2');
        $this->assertSame('action_2', $collector->get('bar:baz'));
    }
}
