<?php

class BaseEntity
{

    public function __call($methodName, $args)
    {

        if(preg_match('~^(set|get)([A-Z])(.*)$~', $methodName, $matches))
        {
            //city
            $property = strtolower($matches[2]) . $matches[3];
            if(!property_exists($this, $property))
            {
                throw new \Exception('Property ' . $property . ' not exists');
            }
            switch ($matches[1])
            {
                case 'set':
                    $this->checkArguments($args, 1, 1, $methodName);
                    return $this->set($property, $args[0]);
                case 'get':
                    $this->checkArguments($args, 0, 0, $methodName);
                    return $this->get($property);
                case 'default':
                    throw new \Exception('Method ' . $methodName . ' not exists');
            }
        }
    }

    public function get($property)
    {
        //city
        return $this->$property;
    }

    public function set($property, $value)
    {
        //city
        $this->$property = $value;
        return $this;
    }

    protected function checkArguments(array $args, $min, $max, $methodName)
    {
        $argc = count($args);
        if($argc < $min || $argc > $max)
        {
            throw new \Exception('Method ' . $methodName . ' needs minimaly ' . $min . ' and maximaly ' . $max . ' arguments. ' . $argc . ' arguments given.');
        }
    }

}
