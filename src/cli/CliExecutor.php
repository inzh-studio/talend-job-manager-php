<?php

namespace inzh\talend\job\manager\cli;

use inzh\talend\job\manager\Job;
use inzh\talend\job\manager\parameter\ContextParameters;
use Exception;

/**
 * Cli job executor
 *
 * @author Jean-Raffi Nazareth <jr-nazareth@inzh.fr>
 * @copyright Copyright © 2011-2022 [InZH] Studio.
 */
class CliExecutor
{
    private $preparator;

    public function __construct(CliPreparator $preparator)
    {
        $this->preparator = $preparator;
    }

    public function execute(Job $job, ContextParameters $contextParameters, $async = false)
    {
        if ($async) {
            return $this->executeAsync($job, $contextParameters);
        } else {
            return $this->executeSync($job, $contextParameters);
        }
    }

    protected function executeAsync(Job $job, ContextParameters $contextParameters)
    {
        throw new Exception("Not implemented");
    }

    protected function executeSync(Job $job, ContextParameters $contextParameters)
    {
        $cmd = $this->preparator->createCommandString($job, $contextParameters);
        exec($cmd, $o, $r);
        if ($r > 0) {
            throw new Exception("Failed to execute job with command : '" . $cmd . '"');
        }
        if ($o != null) {
            $o[] = $cmd;
        }
        return $o;
    }
}
