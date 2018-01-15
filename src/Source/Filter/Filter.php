<?php

namespace Gridly\Source\Filter;

class Filter
{
    public const OP_EQUAL            = 'eq';
    public const OP_NOT_EQUAL        = '!eq';
    public const OP_GREATER          = 'gt';
    public const OP_GREATER_OR_EQUAL = 'gte';
    public const OP_LESS             = 'lt';
    public const OP_LESS_OR_EQUAL    = 'lte';
    public const OP_LIKE             = 'l';
    public const OP_LIKE_LEFT        = 'll';
    public const OP_LIKE_RIGHT       = 'lr';
    public const OP_NOT_LIKE         = '!l';
    public const OP_NOT_LIKE_LEFT    = '!ll';
    public const OP_NOT_LIKE_RIGHT   = '!lr';
    public const OP_IN               = 'in';
    public const OP_NOT_IN           = '!in';
    public const OP_BETWEEN          = 'btw';

    /**
     * @var string  
     */
    private $columnName;

    /**
     * @var string  
     */
    private $operand;

    /**
     * @var mixed  
     */
    private $value;

    /**
     * @param string $columnName
     * @param string $operand
     * @param mixed  $value
     */
    public function __construct(string $columnName, string $operand, $value)
    {
        $this->columnName = $columnName;
        $this->operand = $operand;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getColumnName(): string
    {
        return $this->columnName;
    }

    /**
     * @return mixed
     */
    public function getOperand()
    {
        return $this->operand;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
