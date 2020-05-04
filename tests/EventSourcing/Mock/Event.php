<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing\Mock;

use Ramsey\Uuid\UuidInterface;
use Unixslayer\EventSourcing\AggregateEvent;

final class Event extends AggregateEvent
{
    public static function occur(UuidInterface $aggregateId, array $payload): Event
    {
        return new static($aggregateId, $payload);
    }
}
