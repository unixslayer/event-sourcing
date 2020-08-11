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

use Money\Currency;
use Money\Money;
use Ramsey\Uuid\UuidInterface;
use Unixslayer\Domain\Fixtures\Event\CartWasCreated;
use Unixslayer\Domain\Fixtures\Event\ProductWasAddedToCart;
use Unixslayer\EventSourcing\AggregateEvent;
use Unixslayer\EventSourcing\AggregateRoot;

final class Cart extends AggregateRoot
{
    private Money $balance;

    /** @var Money[] */
    private array $productsBalance = [];

    /** @var int[] */
    private array $productsCount = [];

    public static function create(UuidInterface $uuid, Currency $currency): Cart
    {
        $cart = new self();
        $cart->recordThat(CartWasCreated::occur($uuid, $currency));

        return $cart;
    }

    public function addProduct(Product $product): void
    {
        $cartCurrency = $this->balance->getCurrency();
        $productCurrency = $product->price()->getCurrency();
        if (!$productCurrency->equals($cartCurrency)) {
            throw new \InvalidArgumentException(sprintf('Cart can contain only products with %s currency. %s given.', (string)$cartCurrency, (string)$productCurrency));
        }

        $this->recordThat(ProductWasAddedToCart::occur($this->id, $product));
    }

    public function balance(): Money
    {
        return $this->balance;
    }

    protected function apply(AggregateEvent $event): void
    {
        if ($event instanceof CartWasCreated) {
            $this->cartCreated($event);
        }

        if ($event instanceof ProductWasAddedToCart) {
            $this->productAddedToCart($event);
        }
    }

    private function cartCreated(CartWasCreated $event): void
    {
        $this->id = $event->aggregateId();
        $this->balance = new Money(0, $event->currency());
    }

    private function productAddedToCart(ProductWasAddedToCart $event): void
    {
        $product = $event->product();
        $productId = $product->productId();
        if (array_key_exists((string)$productId, $this->productsCount)) {
            ++$this->productsCount[(string)$productId];
            $this->productsBalance[(string)$productId] = $this->productsBalance[(string)$productId]->add($product->price());
        } else {
            $this->productsCount[(string)$productId] = 1;
            $this->productsBalance[(string)$productId] = $product->price();
        }

        $this->balance = $this->balance->add($product->price());
    }
}
