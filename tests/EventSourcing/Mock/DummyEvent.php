<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing\Mock;

use Ramsey\Uuid\UuidInterface;
use Unixslayer\EventSourcing\Event;

final class DummyEvent extends Event
{
    public static function occur(UuidInterface $aggregateId, array $payload): DummyEvent
    {
        return new static($aggregateId, $payload);
    }
}
