<?php

declare(strict_types=1);

namespace Unixslayer\Domain\Event;

use Money\Currency;
use Ramsey\Uuid\UuidInterface;
use Unixslayer\EventSourcing\Event;

final class CartWasCreated extends Event
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
