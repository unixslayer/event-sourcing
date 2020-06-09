<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing\Mock;

use Ramsey\Uuid\UuidInterface;
use Unixslayer\EventSourcing\Event;

final class CounterWasDecreased extends Event
{
    public static function occur(UuidInterface $aggregateId): self
    {
        return new static($aggregateId);
    }
}
