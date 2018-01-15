<?php

namespace Gridly\Paginator\Adapter;

use Gridly\Source\Source;
use Pagerfanta\Adapter\AdapterInterface as PagerfantaPaginatorAdapterInterface;
use Traversable;

class PagerfantaPaginatorAdapterWrapper implements PagerfantaPaginatorAdapterInterface
{
    /**
     * @var Source
     */
    private $source;

    /**
     * @param Source $source
     */
    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    /**
     * @return int
     */
    public function getNbResults(): int
    {
        return $this->source->count();
    }

    /**
     * @param int $offset
     * @param int $length
     * @return array|iterable|Traversable
     */
    public function getSlice($offset, $length)
    {
        return $this->source->getItems($offset, $length);
    }
}
