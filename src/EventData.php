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
