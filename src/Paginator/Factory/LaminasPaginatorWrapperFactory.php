<?php

namespace Gridly\Paginator\Factory;

use Gridly\Paginator\Adapter\LaminasPaginatorAdapterWrapper;
use Gridly\Paginator\Wrapper\LaminasPaginator;
use Gridly\Source\Source;
use Laminas\Paginator\Paginator;

class LaminasPaginatorWrapperFactory
{
    public static function create(Source $source, array $config): LaminasPaginator
    {
        $paginator = new LaminasPaginator(
            new Paginator(new LaminasPaginatorAdapterWrapper($source))
        );
    
        if (isset($config['itemsPerPage'])) {
            $paginator->setItemsPerPage($config['itemsPerPage']);
        }
        
        return $paginator;
    }
}
