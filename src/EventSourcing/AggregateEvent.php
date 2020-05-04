<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing;

use Ramsey\Uuid\UuidInterface;

class AggregateEvent
{
    private array $payload;
    private array $metadata
        = [
            '_aggregateId' => null,
            '_aggregateVersion' => 1,
        ];

    protected function __construct(UuidInterface $aggregateId, array $payload = [])
    {
        $this->metadata['_aggregateId'] = $aggregateId;

        $this->payload = $payload;
    }

    public function aggregateId(): UuidInterface
    {
        return $this->metadata['_aggregateId'];
    }

    public function payload(): array
    {
        return $this->payload;
    }

    public function version(): int
    {
        return $this->metadata['_aggregateVersion'];
    }

    public function withVersion(int $version): AggregateEvent
    {
        $instance = clone $this;
        $instance->metadata['_aggregateVersion'] = $version;

        return $instance;
    }
}
