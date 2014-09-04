<?php

namespace Afsy\Common\Infra;

use Doctrine\Common\Persistence\ManagerRegistry;
use LiteCQRS\EventStore;
use LiteCQRS\Serializer\ReflectionSerializer;
use Afsy\Common\Infra\DoctrineStorage;

class ORMEventStoreFactory
{
    static public function get(ManagerRegistry $doctrine)
    {
        return new EventStore\OptimisticLocking\OptimisticLockingEventStore(
            new ORMStorage($doctrine),
            new ReflectionSerializer()
        );
    }
}
