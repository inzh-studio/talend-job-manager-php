<?php

namespace inzh\talend\job\manager;

/**
 * Job object
 * Talend Job export, with structure
 *
 * @author Jean-Raffi Nazareth <jr-nazareth@inzh.fr>
 * @copyright Copyright © 2011-2022 [InZH] Studio.
 */
class Job
{
    private $name;
    private $description;
    private $version;

    public function __construct($name, $description, $version)
    {
        $this->name = $name;
        $this->description = $description;
        $this->version = $version;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getVersionPath()
    {
        return $this->name . DIRECTORY_SEPARATOR . $this->version;
    }

    public function getPath()
    {
        return $this->getVersionPath() . DIRECTORY_SEPARATOR . $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }
}
