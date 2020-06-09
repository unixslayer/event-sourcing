<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing\Mock;

use Ramsey\Uuid\UuidInterface;
use Unixslayer\EventSourcing\AggregateRoot;
use Unixslayer\EventSourcing\Event;

final class Aggregate extends AggregateRoot
{
    private int $counter = 0;

    public static function new(UuidInterface $uuid): self
    {
        $self = new self();
        $self->recordThat(WasCreated::occur($uuid));

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

    protected function apply(Event $event): void
    {
        if ($event instanceof WasCreated) {
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
