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

use Money\Money;
use Ramsey\Uuid\UuidInterface;

final class Product
{
    private UuidInterface $productId;
    private Money $price;

    public function __construct(UuidInterface $productId, Money $price)
    {
        $this->productId = $productId;
        $this->price = $price;
    }

    public function productId(): UuidInterface
    {
        return $this->productId;
    }

    public function price(): Money
    {
        return $this->price;
    }
}
