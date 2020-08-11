<?php

declare(strict_types=1);

/**
 * This file is part of `unixslayer/event-sourcing`.
 * (c) 2020 Piotr Zając <piotr.zajac@unixslayer.pl>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Unixslayer\Domain\Fixtures\Event;

use Money\Currency;
use Ramsey\Uuid\UuidInterface;
use Unixslayer\EventSourcing\AggregateEvent;

final class CartWasCreated extends AggregateEvent
{
    public static function occur(UuidInterface $cartId, Currency $currency): CartWasCreated
    {
        $payload = [
            'currency' => $currency->getCode(),
        ];

        return new static($cartId, $payload);
    }

    public function currency(): Currency
    {
        return new Currency($this->payload()['currency']);
    }
}
