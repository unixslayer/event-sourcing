<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Unixslayer\EventSourcing\Mock\DummyAggregateEvent;

final class MessageTransformerTest extends TestCase
{
    public function testItHandlesDomainEventsBothWays(): void
    {
        $transformer = new MessageTransformer();
        $originalEvent = DummyAggregateEvent::occur(Uuid::uuid1(), ['test' => 'payload']);
        $eventData = $transformer->toEventData($originalEvent);
        $event = $transformer->fromEventData($eventData);

        static::assertEquals($originalEvent->uuid(), $event->uuid());
        static::assertEquals($originalEvent->payload(), $event->payload());
        static::assertEquals($originalEvent->aggregateId(), $event->aggregateId());
        static::assertEquals($originalEvent->version(), $event->version());
    }

    public function testItThrowsExceptionWhenMessageNameHasNonExistingClass(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('`\Non\Existing\Class\Name` is not a valid class.');

        $messageData = [
            'message_name' => EventData::class,
            'uuid' => Uuid::NIL,
            'payload' => [],
            'metadata' => [
                '_messageName' => '\\Non\\Existing\\Class\\Name',
            ],
            'created_at' => new \DateTimeImmutable('now'),
        ];
        $eventData = EventData::fromArray($messageData);
        (new MessageTransformer())->fromEventData($eventData);
    }

    public function testItThrowsExceptionWhenMessageNameIsNotProperClassName(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('Message class `stdClass` is not a sub class of `Unixslayer\EventSourcing\AggregateEvent`');

        $messageData = [
            'message_name' => EventData::class,
            'uuid' => Uuid::NIL,
            'payload' => [],
            'metadata' => [
                '_messageName' => \stdClass::class,
            ],
            'created_at' => new \DateTimeImmutable('now'),
        ];
        $eventData = EventData::fromArray($messageData);
        (new MessageTransformer())->fromEventData($eventData);
    }
}
