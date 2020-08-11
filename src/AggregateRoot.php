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

use Ramsey\Uuid\UuidInterface;

abstract class AggregateRoot
{
    protected UuidInterface $id;
    private int $version = 0;
    private array $recordedEvents = [];

    final public function __construct()
    {
    }

    public function version(): int
    {
        return $this->version;
    }

    public function recordedEvents(): array
    {
        $recorderEvents = $this->recordedEvents;
        $this->recordedEvents = [];

        return $recorderEvents;
    }

    public static function fromHistory(iterable $eventsHistory): self
    {
        $instance = new static();
        foreach ($eventsHistory as $event) {
            ++$instance->version;
            $instance->apply($event);
        }

        return $instance;
    }

    final public function aggregateId(): UuidInterface
    {
        return $this->id;
    }

    protected function recordThat(AggregateEvent $event): void
    {
        ++$this->version;
        $this->recordedEvents[] = $event->withAddedMetadata('_aggregateVersion', $this->version);
        $this->apply($event);
    }

    abstract protected function apply(AggregateEvent $event): void;
}
