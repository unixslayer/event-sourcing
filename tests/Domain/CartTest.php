<?php

declare(strict_types=1);

/**
 * This file is part of `unixslayer/event-sourcing`.
 * (c) 2020 Piotr Zając <piotr.zajac@unixslayer.pl>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Unixslayer\Domain;

use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Unixslayer\Domain\Fixtures\Cart;
use Unixslayer\Domain\Fixtures\Product;

final class CartTest extends TestCase
{
    public function testCartWorks(): void
    {
        $cart = Cart::create(Uuid::uuid4(), new Currency('PLN'));

        $products = [
            new Product(Uuid::uuid4(), Money::PLN(1000)),
            new Product(Uuid::uuid4(), Money::PLN(2000)),
            new Product(Uuid::uuid4(), Money::PLN(1500)),
            new Product(Uuid::uuid4(), Money::PLN(3000)),
            new Product(Uuid::uuid4(), Money::PLN(10000)),
        ];

        foreach ($products as $product) {
            $cart->addProduct($product);
        }

        $product = new Product(Uuid::uuid4(), Money::PLN(10000));
        $cart->addProduct($product);
        $cart->addProduct($product);

        $expectedBalance = Money::PLN(37500);
        static::assertEquals($expectedBalance, $cart->balance());

        $this->expectException(\InvalidArgumentException::class);
        $cart->addProduct(new Product(Uuid::uuid4(), Money::USD(1000)));
    }
}
