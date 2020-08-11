<?php

declare(strict_types=1);

/**
 * This file is part of `unixslayer/event-sourcing`.
 * (c) 2020 Piotr Zając <piotr.zajac@unixslayer.pl>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Unixslayer\EventSourcing\Mock;

use Ramsey\Uuid\UuidInterface;
use Unixslayer\EventSourcing\AggregateEvent;
use Unixslayer\EventSourcing\AggregateRoot;

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

    protected function apply(AggregateEvent $event): void
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
