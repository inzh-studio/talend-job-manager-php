<?php

namespace inzh\talend\job\manager\cli;

use inzh\talend\job\manager\Job;
use inzh\talend\job\manager\tool\Env;
use inzh\talend\job\manager\repository\JobRepository;
use inzh\talend\job\manager\parameter\ContextParameters;
use Exception;

/**
 * Cli command preparator for job
 *
 * @author Jean-Raffi Nazareth <jr-nazareth@inzh.fr>
 * @copyright Copyright © 2011-2022 [InZH] Studio.
 */
class CliPreparator
{
    private $repository;

    public function __construct(JobRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getJobRepository()
    {
        return $this->repository;
    }

    public function createCommandString(Job $job, ContextParameters $contextParameters)
    {
        $cmd = $this->getLaunchPath($job);
        $cmd .= " ";
        $cmd .= $this->createParameterArgumentString($contextParameters);
        $cmd .= $this->getOutputRedirection();

        return $cmd;
    }

    protected function getOutputRedirection()
    {
        switch (Env::getCurrent()) {
            case Env::DOS:
                return " 2>&1";
            case Env::UNIX:
                return " 2>&1";
        }
    }

    protected function getLaunchPath(Job $job)
    {
        $fileName = $job->getName() . "_run";
        switch (Env::getCurrent()) {
            case Env::DOS:
                $fileName .= ".bat";
                break;
            case Env::UNIX:
                $fileName .= ".sh";
                break;
        }

        $path = $this->repository->resolve($job->getPath()) . DIRECTORY_SEPARATOR . $fileName;

        if (!is_file($path)) {
            throw new Exception("Missing run file '" . $path . "', please generate job with run script");
        }

        $path = '"' . realpath($path) . '"';

        $interpreter = "";
        if (Env::getCurrent() == Env::UNIX) {
            $interpreter = "bash ";
        }

        $fullPath = $interpreter . $path;
        return $fullPath;
    }

    protected function createParameterArgumentString(ContextParameters $contextParameters)
    {
        $arguments = "";
        foreach ($contextParameters->getAll() as $cp) {
            $arguments .= " --context_param " . $cp->getKey() . "=\"" . addslashes($cp->getValue()) . "\" ";
        }
        return $arguments;
    }
}
