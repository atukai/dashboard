<?php

namespace Gridly\Paginator\Adapter;

use Gridly\Source\Source;
use Laminas\Paginator\Adapter\AdapterInterface as LaminasPaginatorAdapterInterface;

class LaminasPaginatorAdapterWrapper implements LaminasPaginatorAdapterInterface
{
    /** @var Source  */
    private $source;
    
    /**
     * @param Source $source
     */
    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    /**
     * @param int $offset
     * @param int $itemCountPerPage
     * @return array|iterable
     */
    public function getItems($offset, $itemCountPerPage)
    {
        return $this->source->getItems($offset, $itemCountPerPage);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->source->count();
    }
}
