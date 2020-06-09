<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Unixslayer\ProophEventStoreBridge\EventData;

class Event
{
    private UuidInterface $uuid;
    private \DateTimeImmutable $createdAt;
    private array $payload;
    private array $metadata = [
        '_aggregateId' => Uuid::NIL,
        '_aggregateVersion' => 1,
    ];

    protected function __construct(UuidInterface $aggregateId, array $payload = [])
    {
        $this->uuid = Uuid::uuid4();
        $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $this->metadata['_aggregateId'] = (string)$aggregateId;

        $this->payload = $payload;
    }

    public static function fromEventData(EventData $domainMessage): Event
    {
        $messageRef = new \ReflectionClass(\get_called_class());

        /** @var Event $message */
        $message = $messageRef->newInstanceWithoutConstructor();

        $message->uuid = $domainMessage->uuid();
        $message->createdAt = $domainMessage->createdAt();
        $message->metadata = $domainMessage->metadata();
        $message->payload = $domainMessage->payload();

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
    public function withAddedMetadata(string $key, $value): Event
    {
        $message = clone $this;
        $message->metadata[$key] = $value;

        return $message;
    }
}
