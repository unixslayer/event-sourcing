<?php

declare(strict_types=1);

namespace Unixslayer\Domain;

use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Prooph\EventStore\InMemoryEventStore;
use Ramsey\Uuid\Uuid;
use Unixslayer\Domain\Fixtures\Cart;
use Unixslayer\Domain\Fixtures\CartRepository;
use Unixslayer\Domain\Fixtures\Product;
use Unixslayer\EventSourcing\MessageTransformer;
use Unixslayer\TestUtils;

final class CartRepositoryTest extends TestCase
{
    public function testInMemoryRepository(): void
    {
        $cartId = Uuid::uuid4();
        $cart = Cart::create($cartId, new Currency('PLN'));
        $cart->addProduct(new Product(Uuid::uuid4(), Money::PLN(1000)));
        $cart->addProduct(new Product(Uuid::uuid4(), Money::PLN(1000)));

        $repository = new CartRepository(new InMemoryEventStore(), new MessageTransformer());
        $repository->saveAggregateRoot($cart);

        $savedAggregateRoot = $repository->getAggregateRoot($cartId);
        static::assertEquals($cart, $savedAggregateRoot);
    }

    /** @group database */
    public function testPostgresRepository(): void
    {
        $cartId = Uuid::uuid4();
        $cart = Cart::create($cartId, new Currency('PLN'));
        $cart->addProduct(new Product(Uuid::uuid4(), Money::PLN(1000)));
        $cart->addProduct(new Product(Uuid::uuid4(), Money::PLN(1000)));

        $repository = new CartRepository(TestUtils::postgresEventStore(), new MessageTransformer());
        $repository->saveAggregateRoot($cart);

        $savedAggregateRoot = $repository->getAggregateRoot($cartId);
        static::assertEquals($cart, $savedAggregateRoot);
    }

    /** @group database */
    public function testMySqlRepository(): void
    {
        $cartId = Uuid::uuid4();
        $cart = Cart::create($cartId, new Currency('PLN'));
        $cart->addProduct(new Product(Uuid::uuid4(), Money::PLN(1000)));
        $cart->addProduct(new Product(Uuid::uuid4(), Money::PLN(1000)));

        $repository = new CartRepository(TestUtils::mySqlEventStore(), new MessageTransformer());
        $repository->saveAggregateRoot($cart);

        $savedAggregateRoot = $repository->getAggregateRoot($cartId);
        static::assertEquals($cart, $savedAggregateRoot);
    }
}
