<?php

declare(strict_types=1);

namespace Unixslayer\Domain\Fixtures\Event;

use Money\Currency;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Unixslayer\Domain\Fixtures\Product;
use Unixslayer\EventSourcing\AggregateEvent;

final class ProductWasAddedToCart extends AggregateEvent
{
    public static function occur(UuidInterface $cartId, Product $product): ProductWasAddedToCart
    {
        $payload = [
            'productId' => $product->productId()->toString(),
            'productPrice' => $product->price()->getAmount(),
            'productCurrency' => $product->price()->getCurrency()->getCode(),
        ];

        return new static($cartId, $payload);
    }

    public function product(): Product
    {
        $productId = Uuid::fromString($this->payload()['productId']);
        $price = new Money($this->payload()['productPrice'], new Currency($this->payload()['productCurrency']));

        return new Product($productId, $price);
    }
}
