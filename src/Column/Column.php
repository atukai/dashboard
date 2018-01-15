<?php

namespace Gridly\Column;

class Column
{
    /** @var string  */
    private $name;
    
    /** @var mixed */
    private $value;

    /**
     * @param string $name
     * @param $value
     */
    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
    
    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }
}
