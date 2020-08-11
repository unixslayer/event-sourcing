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
use Unixslayer\EventSourcing\Mock\Repository;
use Unixslayer\TestUtils;

/** @group database */
final class MySqlAggregateRepositoryTest extends TestCase
{
    public function testRepositoryCanSaveAggregateRoot(): void
    {
        $repository = new Repository(TestUtils::mySqlEventStore(), new MessageTransformer());

        $uuid = Uuid::uuid4();
        $aggregate = Aggregate::new($uuid);
        $aggregate->increaseCounter();
        $repository->saveAggregateRoot($aggregate);

        static::assertEmpty($aggregate->recordedEvents());

        $savedAggregate = $repository->getAggregateRoot($uuid);

        static::assertEquals($aggregate, $savedAggregate);
    }
}
