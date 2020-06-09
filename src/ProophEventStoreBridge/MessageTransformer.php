<?php

declare(strict_types=1);

namespace Unixslayer\ProophEventStoreBridge;

use Prooph\Common\Messaging\Message;
use Unixslayer\EventSourcing\Event;

final class MessageTransformer
{
    public function toEventData(Event $event): Message
    {
        $event = $event->withAddedMetadata('_messageName', \get_class($event));

        $messageData = [
            'uuid' => $event->uuid()->toString(),
            'message_name' => EventData::class,
            'created_at' => $event->createdAt(),
            'payload' => $event->payload(),
            'metadata' => $event->metadata(),
        ];

        return EventData::fromArray($messageData);
    }

    public function fromEventData(EventData $eventData): Event
    {
        $messageName = $eventData->metadata()['_messageName'];

        if (!\class_exists($messageName)) {
            throw new \UnexpectedValueException(sprintf('`%s` is not a valid class.', $messageName));
        }

        if (!\is_subclass_of($messageName, Event::class)) {
            throw new \UnexpectedValueException(\sprintf(
                'Message class %s is not a sub class of %s',
                $messageName,
                Event::class
            ));
        }

        return $messageName::fromEventData($eventData);
    }
}
