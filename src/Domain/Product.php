<?php

declare(strict_types=1);

namespace Unixslayer\Domain;

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
