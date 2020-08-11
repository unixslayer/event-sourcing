<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing\Mock;

use Unixslayer\EventSourcing\AggregateEvent;
use Unixslayer\EventSourcing\AggregateRoot;

final class DummyAggregate extends AggregateRoot
{
    public static function new(): self
    {
        return new self();
    }

    protected function apply(AggregateEvent $event): void
    {
    }
}
