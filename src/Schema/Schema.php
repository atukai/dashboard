<?php

namespace Gridly\Schema;

use Gridly\Source\Filter\Filter;
use Gridly\Source\Order\Order;

class Schema
{
    /** @var Filter[]  */
    private $filters;
    
    /** @var Order */
    private $order;
    
    /**
     * @param Order $order
     * @param Filter[] $filters
     */
    public function __construct(Order $order, iterable $filters = [])
    {
        $this->order = $order;
        $this->filters = $filters;
    }
    
    public function getOrder(): Order
    {
        return $this->order;
    }
    
    public function getFilters(): iterable
    {
        return $this->filters;
    }
}
