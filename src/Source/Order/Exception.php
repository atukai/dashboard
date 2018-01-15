<?php

namespace Gridly\Source\Order;

class Exception extends \Gridly\Exception
{
    /**
     * @param string $direction
     * @throws Exception
     */
    public static function onInvalidOrderDirection(string $direction): void
    {
        throw new self('Invalid order direction "'. $direction . '" provided');
    }
}
