<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing;

use Prooph\Common\Messaging\DomainEvent;

final class EventData extends DomainEvent
{
    private array $payload;

    public function payload(): array
    {
        return $this->payload;
    }

    protected function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }
}
