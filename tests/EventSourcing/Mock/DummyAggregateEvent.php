<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing\Mock;

use Ramsey\Uuid\UuidInterface;
use Unixslayer\EventSourcing\AggregateEvent;

final class DummyAggregateEvent extends AggregateEvent
{
    public static function occur(UuidInterface $aggregateId, array $payload): DummyAggregateEvent
    {
        return new static($aggregateId, $payload);
    }
}
