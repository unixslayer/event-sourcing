<?php

declare(strict_types=1);

namespace Unixslayer\Domain;

use Prooph\EventStore\StreamName;
use Unixslayer\EventSourcing\AggregateRepository;

final class CartRepository extends AggregateRepository
{
    protected function aggregateType(): string
    {
        return Cart::class;
    }

    protected function streamName(): StreamName
    {
        return new StreamName('cart');
    }
}
