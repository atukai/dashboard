<?php

namespace Gridly\Paginator\Wrapper;

use Gridly\Paginator\Paginator;
use Pagerfanta\Pagerfanta;

class PagerfantaPaginator implements Paginator
{
    /** @var Pagerfanta */
    private $pagerfantaPaginator;
    
    /**
     * @param Pagerfanta $paginator
     */
    public function __construct(Pagerfanta $paginator)
    {
        $this->pagerfantaPaginator = $paginator;
    }

    public function setItemsPerPage(int $count = 10): Paginator
    {
        $this->pagerfantaPaginator->setMaxPerPage($count);
        return $this;
    }

    public function getPageItems(int $page = 1): iterable
    {
        $this->pagerfantaPaginator->setCurrentPage($page);
        return $this->pagerfantaPaginator->getCurrentPageResults();
    }

    public function getCurrentPage(): int
    {
        return $this->pagerfantaPaginator->getCurrentPage();
    }

    public function getTotalPages(): int
    {
        return $this->pagerfantaPaginator->getNbPages();
    }
}
