<?php

namespace inzh\talend\job\manager\repository;

/**
 * Job repository object
 * Contains all jobs by version
 *
 * @author Jean-Raffi Nazareth <jr-nazareth@inzh.fr>
 * @copyright Copyright © 2011-2022 [InZH] Studio.
 */
class JobRepository
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function resolve($path)
    {
        $r = $this->getPath() . DIRECTORY_SEPARATOR . $path;
        return $r;
    }
}
