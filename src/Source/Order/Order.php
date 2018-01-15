<?php

namespace Gridly\Source\Order;

use function in_array;

class Order
{
    public const DIRECTION_ASC = 'asc';
    public const DIRECTION_DESC = 'desc';
    
    /** @var string */
    private $columnName;

    /** @var string */
    private $direction;

    /** @var array */
    private static $directions = [self::DIRECTION_ASC, self::DIRECTION_DESC];
    
    /**
     * @param string $columnName
     * @param string $direction
     * @throws Exception
     */
    public function __construct(string $columnName, string $direction)
    {
        $this->columnName = $columnName;

        $direction = strtolower($direction);
        if (!in_array($direction, self::$directions, true)) {
            Exception::onInvalidOrderDirection($direction);
        }
        $this->direction = $direction;
    }

    public function getColumnName(): string
    {
        return $this->columnName;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }
}
