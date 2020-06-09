<?php

declare(strict_types=1);

namespace Unixslayer\EventSourcing;

use Prooph\EventStore\EventStore;
use Prooph\EventStore\Exception\StreamNotFound;
use Prooph\EventStore\Metadata\MetadataMatcher;
use Prooph\EventStore\Metadata\Operator;
use Prooph\EventStore\Stream;
use Prooph\EventStore\StreamName;
use Ramsey\Uuid\UuidInterface;
use Unixslayer\ProophEventStoreBridge\EventData;
use Unixslayer\ProophEventStoreBridge\MessageTransformer;

abstract class AggregateRepository
{
    private EventStore $eventStore;
    private MessageTransformer $messageTransformer;

    public function __construct(EventStore $eventStore, MessageTransformer $messageTransformer)
    {
        $this->eventStore = $eventStore;
        $this->messageTransformer = $messageTransformer;
    }

    public function saveAggregateRoot(AggregateRoot $aggregateRoot): void
    {
        if (($aggregateType = \get_class($aggregateRoot)) !== $this->aggregateType()) {
            throw new \InvalidArgumentException(sprintf('Expecting %s, got %s', $this->aggregateType(), $aggregateType));
        }

        $events = $aggregateRoot->recordedEvents();
        if (empty($events)) {
            return;
        }

        $events = array_reduce($events, function (array $carrier, Event $aggregateEvent) {
            $eventData = $this->messageTransformer->toEventData($aggregateEvent);
            $eventData = $eventData->withAddedMetadata('_aggregateType', $this->aggregateType());
            $carrier[] = $eventData;

            return $carrier;
        }, []);

        $streamEvents = new \ArrayIterator($events);

        try {
            $this->eventStore->appendTo($this->streamName(), $streamEvents);
        } catch (StreamNotFound $e) {
            //if event stream was not found, repository will tell EventStore to create new one saving events
            $stream = new Stream($this->streamName(), $streamEvents);
            $this->eventStore->create($stream);
        }
    }

    public function getAggregateRoot(UuidInterface $aggregateId): ?AggregateRoot
    {
        $streamName = $this->streamName();
        $metadataMatcher = new MetadataMatcher();
        $aggregateType = $this->aggregateType();
        $metadataMatcher = $metadataMatcher->withMetadataMatch('_aggregateType', Operator::EQUALS(), $aggregateType);
        $metadataMatcher = $metadataMatcher->withMetadataMatch('_aggregateId', Operator::EQUALS(), (string)$aggregateId);

        try {
            $streamEvents = $this->eventStore->load($streamName, 1, null, $metadataMatcher);
        } catch (StreamNotFound $e) {
            return null;
        }

        if (!$streamEvents->valid()) {
            return null;
        }

        $aggregateEvents = array_reduce(iterator_to_array($streamEvents), function (array $carrier, EventData $eventData) {
            $carrier[] = $this->messageTransformer->fromEventData($eventData);

            return $carrier;
        }, []);

        return $aggregateType::fromHistory($aggregateEvents);
    }

    abstract protected function aggregateType(): string;

    abstract protected function streamName(): StreamName;
}
