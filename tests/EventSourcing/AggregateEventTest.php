<?php

declare(strict_types=1);

/**
 * This file is part of `unixslayer/event-sourcing`.
 * (c) 2020 Piotr Zając <piotr.zajac@unixslayer.pl>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Unixslayer\EventSourcing;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Unixslayer\EventSourcing\Mock\DummyAggregateEvent;

final class AggregateEventTest extends TestCase
{
    public function testEventAssignsAttributesProperly(): void
    {
        $aggregateId = Uuid::uuid1();
        $payload = [
            'key' => 'value',
        ];

        $event = DummyAggregateEvent::occur($aggregateId, $payload);
        static::assertEquals($aggregateId, $event->aggregateId());
        static::assertEquals($payload, $event->payload());
    }

    public function testEventCanTrackVersion(): void
    {
        $aggregateId = Uuid::uuid1();
        $event = DummyAggregateEvent::occur($aggregateId, []);
        $anotherEvent = $event->withAddedMetadata('_aggregateVersion', 2);

        static::assertEquals(1, $event->version());
        static::assertEquals(2, $anotherEvent->version());
    }
}
