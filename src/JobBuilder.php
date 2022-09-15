<?php

namespace inzh\talend\job\manager;

use inzh\talend\job\manager\Job;
use inzh\talend\job\manager\tool\StringTool;

class JobBuilder
{
    public function createWithPath($path)
    {
        $pi = pathinfo(realpath($path));
        return $this->createWithFileName($pi['basename']);
    }

    public function create($name, $version)
    {
        if (is_string($version)) {
            $version = doubleval($version);
        }
        $job = new Job($name, null, $version);
        return $job;
    }

    public function createWithFileName($fileName)
    {
        $version = null;

        if (StringTool::endsWith($fileName, ".zip")) {
            $fileName = mb_substr($fileName, 0, -4);
        }

        $sp = explode("_", $fileName);
        $name = $sp[0];

        if (count($sp) > 1) {
            $version = doubleval($sp[1]);
        }

        $job = new Job($name, null, $version);
        return $job;
    }
}
