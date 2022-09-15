<?php

namespace inzh\talend\job\manager\parameter;

class ContextParameter
{
    private $key;
    private $value;

    public function __construct($key, $value = null)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }
}
