<?php

namespace Gridly\Column;

class CallableDecorator implements Decorator
{
    /** @var callable  */
    private $callable;
    
    /**
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * @param Column $column
     * @return Column
     */
    public function __invoke(Column $column): Column
    {
        $decorator = $this->callable;
        return $decorator($column);
    }
}
