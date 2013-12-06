<?php

namespace Afsy\CQRS;

use LiteCQRS\EventStore\OptimisticLocking\Storage;
use Afsy\Bundle\EventStoreBundle\Entity\StreamData;
use Rhumsaa\Uuid\Uuid;

class DoctrineStorage implements Storage
{
    protected $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load($id)
    {
        return $this
            ->doctrine
            ->getManager()
            ->getRepository('Afsy\Bundle\EventStoreBundle\Entity\StreamData')
            ->find(Uuid::fromString($id))
        ;
    }

    public function store($id, $className, $eventData, $nextVersion, $currentVersion)
    {
        /*if (isset($this->streamData[$id]) && $this->streamData[$id]->getVersion() !== $currentVersion) {
            throw new ConcurrencyException();
        }*/

        if ($this->contains($id)) {
            $streamData = $this->load($id);
            $streamData->setEventData($eventData);
            $streamData->setVersion($nextVersion);
        } else {
            $streamData = new StreamData(Uuid::fromString($id), $className, $eventData, $nextVersion);
        }

        $this->doctrine->getManager()->persist($streamData);
        $this->doctrine->getManager()->flush();
    }

    public function contains($id)
    {
        return null !== $this->load($id);
    }
}