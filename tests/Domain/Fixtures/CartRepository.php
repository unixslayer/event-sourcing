<?php

declare(strict_types=1);

/**
 * This file is part of `unixslayer/event-sourcing`.
 * (c) 2020 Piotr Zając <piotr.zajac@unixslayer.pl>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Unixslayer\Domain\Fixtures;

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
