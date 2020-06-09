<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Unixslayer\EventSourcing\Mock\Aggregate;
use Unixslayer\EventSourcing\Mock\Repository;
use Unixslayer\ProophEventStoreBridge\MessageTransformer;
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
