<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing\Mock;

use Unixslayer\EventSourcing\AggregateRoot;
use Unixslayer\EventSourcing\Event;

final class DummyAggregate extends AggregateRoot
{
    public static function new(): self
    {
        return new self();
    }

    protected function apply(Event $event): void
    {
    }
}
