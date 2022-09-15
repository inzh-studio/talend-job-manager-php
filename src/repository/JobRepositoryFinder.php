<?php

namespace inzh\talend\job\manager\repository;

use ArrayObject;
use ZipArchive;
use inzh\talend\job\manager\tool\FileTool;
use inzh\talend\job\manager\JobBuilder;
use inzh\talend\job\manager\Job;

/**
 * Job Repository Finder object
 * Navigator for manage and browse jobs in repository
 *
 * @author Jean-Raffi Nazareth <jr-nazareth@inzh.fr>
 * @copyright Copyright © 2011-2022 [InZH] Studio.
 */
class JobRepositoryFinder
{
    protected $repository;
    protected $jobs;

    public function __construct(JobRepository $repository)
    {
        $this->repository = $repository;
    }

    public function compareName(Job $job1, Job $job2)
    {
        $n1 = $job1->getName();
        $n2 = $job2->getName();
        if ($n1 == $n2) {
            return 0;
        }
        return ($n1 < $n2) ? -1 : 1;
    }

    public function rcompareVersion(Job $job1, Job $job2)
    {
        $re = $this->compareName($job1, $job2);
        if ($re == 0) {
            $v1 = $job1->getVersion();
            $v2 = $job2->getVersion();
            if ($v1 == $v2) {
                return 0;
            }
            return ($v1 > $v2) ? -1 : 1;
        }
        return $re;
    }

    protected function read($repositoryPath)
    {
        $builder = new JobBuilder();

        $ao = new ArrayObject();
        $ls = FileTool::getList($repositoryPath);

        foreach ($ls as $f) {
            if (is_dir($f["file"])) {
                $versions = FileTool::getList($f["file"]);
                foreach ($versions as $version) {
                    $job = $builder->create($f["basename"], $version["basename"]);
                    $ao->append($job);
                }
            }
        }
        $re = $ao->uasort([$this, "rcompareVersion"]);
        return $ao;
    }

    public function getJobs()
    {
        if (!isset($this->jobs)) {
            $this->jobs = $this->read($this->repository->getPath());
        }
        return $this->jobs;
    }

    public function put($path)
    {
        $builder = new JobBuilder();
        $job = $builder->createWithFileName(basename($path));

        $target = $this->repository->resolve($job->getVersionPath());
        if (!is_dir($target)) {
            mkdir($target, 0775, true);
        }

        // Extract to repository
        $za = new ZipArchive();
        $za->open($path);
        $za->extractTo($target);
        $za->close();

        unset($this->jobs);
        return $job;
    }

    protected function isEquals(Job $job, $name, $version = null)
    {
        if ($job->getName() == $name) {
            if (isset($version)) {
                return $job->getVersion() == $version;
            }
            return true;
        }
        return false;
    }

    public function get($name, $version = null)
    {
        $js = $this->getJobs();

        foreach ($js as $job) {
            if ($this->isEquals($job, $name, $version)) {
                return $job;
            }
        }

        return null;
    }
}
