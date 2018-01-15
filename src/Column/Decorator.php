<?php

namespace Gridly\Column;

interface Decorator
{
    /**
     * @param Column $column
     * @return Column
     */
    public function __invoke(Column $column): Column;
}