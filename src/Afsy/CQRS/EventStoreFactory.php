<?php

namespace Afsy\CQRS;

use LiteCQRS\EventStore;
use LiteCQRS\Serializer\ReflectionSerializer;
use Afsy\CQRS\DoctrineStorage;

class EventStoreFactory
{
    static public function get($doctrine)
    {
        return new EventStore\OptimisticLocking\OptimisticLockingEventStore(
            new DoctrineStorage($doctrine),
            new ReflectionSerializer()
        );
    }
}