<?php

namespace Afsy\Common\Infra;

use Doctrine\Common\Persistence\ManagerRegistry;
use LiteCQRS\EventStore\OptimisticLocking\Storage;
use Rhumsaa\Uuid\Uuid;
use Afsy\Common\Domain\Entity\StreamData;

class ORMStorage implements Storage
{
    protected $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load($id)
    {
        return $this
            ->doctrine
            ->getManager()
            ->getRepository('Afsy\Common\Domain\Entity\StreamData')
            ->find(Uuid::fromString($id))
        ;
    }

    public function store($id, $className, $eventData, $nextVersion, $currentVersion)
    {
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
