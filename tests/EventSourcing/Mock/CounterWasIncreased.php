<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing\Mock;

use Ramsey\Uuid\UuidInterface;
use Unixslayer\EventSourcing\AggregateEvent;

final class CounterWasIncreased extends AggregateEvent
{
    public static function occur(UuidInterface $aggregateId): self
    {
        return new static($aggregateId);
    }
}
