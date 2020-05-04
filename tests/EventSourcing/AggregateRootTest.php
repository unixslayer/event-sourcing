<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing;

use PHPUnit\Framework\TestCase;
use Unixslayer\EventSourcing\Mock\Aggregate;

final class AggregateRootTest extends TestCase
{
    public function testAggregateRootAppliesEventsProperly(): void
    {
        $aggregate = Aggregate::new();
        $aggregate->increaseCounter();
        $aggregate->increaseCounter();
        $aggregate->decreaseCounter();
        $aggregate->increaseCounter();

        static::assertEquals(2, $aggregate->counter());

        $events = $aggregate->recordedEvents();
        $recreatedAggregate = Aggregate::fromHistory($events);

        static::assertEquals(2, $recreatedAggregate->counter());
        static::assertEquals($aggregate->version(), $recreatedAggregate->version());
    }
}
