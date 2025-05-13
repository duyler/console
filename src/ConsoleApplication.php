<?php

declare(strict_types=1);

namespace Duyler\Console;

use Duyler\Builder\ApplicationBuilder;
use Duyler\EventBus\Build\Action;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

final class ConsoleApplication
{
    public function run(): void
    {
        if ('cli' !== php_sapi_name()) {
            throw new RuntimeException('Application can only be run from cli');
        }

        $applicationBuilder = new ApplicationBuilder();

        $container = $applicationBuilder->getContainer();

        /** @var CommandCollector $commandCollector */
        $commandCollector = $container->get(CommandCollector::class);

        $argv = $_SERVER['argv'] ?? throw new RuntimeException('Command line arguments not resolved');

        $busBuilder = $applicationBuilder->getBusBuilder();

        $bus = $busBuilder
            ->loadPackages()
            ->loadBuild();

        $command = $argv[1];

        if (false === $commandCollector->has($command)) {
            throw new InvalidArgumentException("Command [$command] not found.");
        }

        $actionId = $commandCollector->get($command);

        $busBuilder->doAction(new Action(
            id: 'DoCommand',
            handler: function () {},
            required: [
                $actionId,
            ],
        ));

        $bus = $busBuilder->build();

        try {
            $bus->run();
        } catch (Throwable $exception) {
            $bus->reset();
            $applicationBuilder->getContainer()->finalize();
            throw $exception;
        }
    }
}
