<?php

namespace inzh\talend\job\manager\parameter;

class ContextParameters
{
    private $contextParameters = [];

    public function add($key, $value)
    {
        $p = new ContextParameter($key, $value);
        $i = $this->indexOf($key);
        if ($i > -1) {
            unset($this->contextParameters[$i]);
        }
        $this->contextParameters[] = $p;
        return $p;
    }

    public function fromArray($ar)
    {
        foreach ($ar as $key => $value) {
            $this->add($key, $value);
        }
        return $this;
    }

    public function addAll($contextParameters)
    {
        foreach ($contextParameters as $cp) {
            $this->add($cp->getKey(), $cp->getValue());
        }
        return $this;
    }

    public function getAll()
    {
        return $this->contextParameters;
    }

    public function indexOf($key)
    {
        $all = $this->getAll();
        $cpt = count($all);

        for ($i = 0; $i < $cpt; $i++) {
            $cp = $all[$i];
            if ($cp->getKey() == $key) {
                return $i;
            }
        }
        return -1;
    }

    public function get($key)
    {
        foreach ($this->getAll() as $cp) {
            if ($cp->getKey() == $key) {
                return $cp;
            }
        }
        return null;
    }
}
