<?php

namespace Afsy\Bundle\EventStoreBundle\Entity;

class StreamData
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var array
     */
    private $eventData;

    /**
     * @var string
     */
    private $version;

    /**
     * @var uuid
     */
    private $id;

    public function __construct($id, $className, $eventData, $version)
    {
        $this->id = $id;
        $this->eventData = $eventData;
        $this->className = $className;
        $this->version = $version;
    }


    /**
     * Set className
     *
     * @param string $className
     * @return StreamData
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * Get className
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Set eventData
     *
     * @param array $eventData
     * @return StreamData
     */
    public function setEventData($eventData)
    {
        $this->eventData = $eventData;

        return $this;
    }

    /**
     * Get eventData
     *
     * @return array
     */
    public function getEventData()
    {
        return $this->eventData;
    }

    /**
     * Set Version
     *
     * @param string $version
     * @return StreamData
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get nextVersion
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set id
     *
     * @param uuid $id
     * @return StreamData
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return uuid
     */
    public function getId()
    {
        return $this->id;
    }
}