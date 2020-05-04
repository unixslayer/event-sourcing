<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing\Mock;

use Ramsey\Uuid\Uuid;
use Unixslayer\EventSourcing\AggregateEvent;
use Unixslayer\EventSourcing\AggregateRoot;

final class Aggregate extends AggregateRoot
{
    private int $counter = 0;

    public static function new(): self
    {
        $id = Uuid::uuid1();

        $self = new self();
        $self->recordThat(AggregateWasCreated::occur($id));

        return $self;
    }

    public function counter(): int
    {
        return $this->counter;
    }

    public function increaseCounter(): void
    {
        $this->recordThat(CounterWasIncreased::occur($this->aggregateId()));
    }

    public function decreaseCounter(): void
    {
        $this->recordThat(CounterWasDecreased::occur($this->aggregateId()));
    }

    protected function apply(AggregateEvent $event): void
    {
        if ($event instanceof AggregateWasCreated) {
            $this->id = $event->aggregateId();
        }
        if ($event instanceof CounterWasIncreased) {
            ++$this->counter;
        }
        if ($event instanceof CounterWasDecreased) {
            --$this->counter;
        }
    }
}
