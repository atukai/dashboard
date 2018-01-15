<?php

namespace Gridly\Paginator\Factory;

use Gridly\Paginator\Adapter\PagerfantaPaginatorAdapterWrapper;
use Gridly\Paginator\Wrapper\PagerfantaPaginator;
use Gridly\Source\Source;
use Pagerfanta\Pagerfanta;

class PagerfantaPaginatorWrapperFactory
{
    public static function create(Source $source, array $config): PagerfantaPaginator
    {
        $paginator = new PagerfantaPaginator(
            new Pagerfanta(new PagerfantaPaginatorAdapterWrapper($source))
        );
        
        if (isset($config['itemsPerPage'])) {
            $paginator->setItemsPerPage($config['itemsPerPage']);
        }
        
        return $paginator;
    }
}
