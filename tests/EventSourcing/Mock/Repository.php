<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing\Mock;

use Prooph\EventStore\StreamName;
use Unixslayer\EventSourcing\AggregateRepository;

final class Repository extends AggregateRepository
{
    protected function aggregateType(): string
    {
        return Aggregate::class;
    }

    protected function streamName(): StreamName
    {
        return new StreamName('aggregate');
    }
}
