<?php

declare(strict_types=1);

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
        $this->recordedEvents[] = $event->withVersion($this->version);
        $this->apply($event);
    }

    abstract protected function apply(AggregateEvent $event): void;
}
