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
use Unixslayer\EventSourcing\Mock\Aggregate;

final class AggregateRootTest extends TestCase
{
    public function testAggregateRootAppliesEventsProperly(): void
    {
        $aggregate = Aggregate::new(Uuid::uuid4());
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
