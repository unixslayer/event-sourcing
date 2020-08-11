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
use Prooph\EventStore\InMemoryEventStore;
use Ramsey\Uuid\Uuid;
use Unixslayer\EventSourcing\Mock\Aggregate;
use Unixslayer\EventSourcing\Mock\DummyAggregate;
use Unixslayer\EventSourcing\Mock\Repository;

final class AggregateRepositoryTest extends TestCase
{
    private Repository $repository;

    protected function setUp(): void
    {
        $this->repository = new Repository(new InMemoryEventStore(), new MessageTransformer());
    }

    public function testRepositoryCanSaveAndLoadAggregateRoot(): void
    {
        $uuid = Uuid::uuid4();
        $aggregate = Aggregate::new($uuid);
        $aggregate->increaseCounter();
        $this->repository->saveAggregateRoot($aggregate);

        static::assertEmpty($aggregate->recordedEvents());

        $savedAggregate = $this->repository->getAggregateRoot($uuid);

        static::assertEquals($aggregate, $savedAggregate);

        //saving the same aggregate twice doesn't fail
        $this->repository->saveAggregateRoot($aggregate);
        //repository returns null if aggregate not exists
        static::assertNull($this->repository->getAggregateRoot(Uuid::uuid4()));
    }

    public function testRepositoryThrowsExceptionForInvalidAggregate(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $aggregate = DummyAggregate::new();

        $this->repository->saveAggregateRoot($aggregate);
    }

    public function testItReturnsNullWhenStreamNotFound(): void
    {
        $repository = new Repository(new InMemoryEventStore(), new MessageTransformer());
        $aggregate = $repository->getAggregateRoot(Uuid::uuid1());

        static::assertNull($aggregate);
    }
}
