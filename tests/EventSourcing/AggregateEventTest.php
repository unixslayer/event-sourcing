<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Unixslayer\EventSourcing\Mock\DummyEvent;

final class AggregateEventTest extends TestCase
{
    public function testEventAssignsAttributesProperly(): void
    {
        $aggregateId = Uuid::uuid1();
        $payload = [
            'key' => 'value',
        ];

        $event = DummyEvent::occur($aggregateId, $payload);
        static::assertEquals($aggregateId, $event->aggregateId());
        static::assertEquals($payload, $event->payload());
    }

    public function testEventCanTrackVersion(): void
    {
        $aggregateId = Uuid::uuid1();
        $event = DummyEvent::occur($aggregateId, []);
        $anotherEvent = $event->withAddedMetadata('_aggregateVersion', 2);

        static::assertEquals(1, $event->version());
        static::assertEquals(2, $anotherEvent->version());
    }
}
