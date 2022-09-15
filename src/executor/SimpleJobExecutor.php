<?php

namespace inzh\talend\job\manager\executor;

use inzh\talend\job\manager\repository\JobRepository;
use inzh\talend\job\manager\repository\JobRepositoryFinder;
use inzh\talend\job\manager\cli\CliPreparator;
use inzh\talend\job\manager\cli\CliExecutor;
use inzh\talend\job\manager\parameter\ContextParameters;
use Exception;

/**
 * Simple executor for Talend job in repository
 *
 * @author Jean-Raffi Nazareth <jr-nazareth@inzh.fr>
 * @copyright Copyright © 2011-2022 [InZH] Studio.
 */
class SimpleJobExecutor
{
    /**
     * Put job in repository from zip file
     *
     * @param string $path Zip file path
     * @param string $repositoryPath Repository path
     * @return inzh\talend\job\manager\Job Job updated
     */
    public static function put($path, $repositoryPath)
    {
        if (!isset($repositoryPath)) {
            throw new Exception("Repository path missing");
        }

        $repository = new JobRepository($repositoryPath);

        $jf = new JobRepositoryFinder($repository);
        return $jf->put($path);
    }

    /**
     * Execute specific job with parameters
     *
     * @param string $jobName Job name
     * @param array $parameters Array of contexts parameters passed on job, empty if no parameters
     * @param string $repositoryPath Repository path
     * @param string $version Version of job, not set or null for last version
     * @return array execute output
     */
    public static function execute($jobName, array $parameters, $repositoryPath, $version = null)
    {
        if (!isset($repositoryPath)) {
            throw new Exception("Repository path missing");
        }

        $repository = new JobRepository($repositoryPath);

        $jf = new JobRepositoryFinder($repository);
        $job = $jf->get($jobName, $version);

        if (!isset($job)) {
            $message = "The job '$jobName'";
            if (isset($version)) {
                $message .= " on version $version";
            }
            $message .= " not exist in '" . $repositoryPath . "'";
            throw new Exception($message);
        }

        $cps = new ContextParameters();
        $cps->fromArray($parameters);

        $jp = new CliPreparator($repository);
        $je = new CliExecutor($jp);

        return $je->execute($job, $cps);
    }
}
