<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing;

use PHPUnit\Framework\TestCase;
use Prooph\EventStore\InMemoryEventStore;
use Ramsey\Uuid\Uuid;
use Unixslayer\EventSourcing\Mock\Aggregate;
use Unixslayer\EventSourcing\Mock\DummyAggregate;
use Unixslayer\EventSourcing\Mock\Repository;
use Unixslayer\ProophEventStoreBridge\MessageTransformer;

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
}
