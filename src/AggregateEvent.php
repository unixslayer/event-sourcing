<?php

declare(strict_types=1);

/**
 * This file is part of `unixslayer/event-sourcing`.
 * (c) 2020 Piotr Zając <piotr.zajac@unixslayer.pl>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Unixslayer\EventSourcing;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AggregateEvent
{
    private UuidInterface $uuid;
    private \DateTimeImmutable $createdAt;
    private array $payload;
    private array $metadata = [
        '_aggregateId' => Uuid::NIL,
        '_aggregateVersion' => 1,
        '_eventVersion' => 1,
        '_messageName' => null,
    ];

    protected function __construct(UuidInterface $aggregateId, array $payload = [])
    {
        $this->uuid = Uuid::uuid4();
        $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $this->metadata['_aggregateId'] = (string)$aggregateId;

        $this->payload = $payload;
    }

    public static function fromEventData(string $messageName, UuidInterface $uuid, \DateTimeImmutable $createdAt, array $metadata, array $payload): AggregateEvent
    {
        $messageRef = new \ReflectionClass($messageName);

        /** @var AggregateEvent $message */
        $message = $messageRef->newInstanceWithoutConstructor();

        $message->uuid = $uuid;
        $message->createdAt = $createdAt;
        $message->metadata = $metadata;
        $message->payload = $payload;

        return $message;
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function aggregateId(): UuidInterface
    {
        return Uuid::fromString($this->metadata['_aggregateId']);
    }

    public function payload(): array
    {
        return $this->payload;
    }

    public function metadata(): array
    {
        return $this->metadata;
    }

    public function version(): int
    {
        return $this->metadata['_aggregateVersion'];
    }

    /** @psalm-suppress MissingParamType */
    public function withAddedMetadata(string $key, $value): AggregateEvent
    {
        $message = clone $this;
        $message->metadata[$key] = $value;

        return $message;
    }
}
