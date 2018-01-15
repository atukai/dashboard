<?php

namespace Gridly\Source\Filter;

class Exception extends \Gridly\Exception
{
    /**
     * @param string $operand
     * @param string $source
     * @throws Exception
     */
    public static function onUnsupportedFilterOperand(string $operand, string $source): void
    {
        throw new self('Operand "'. $operand . '" not supported for source ' . $source);
    }
}
