<?php

namespace Gridly\Paginator;

interface Paginator
{
    public function setItemsPerPage(int $count): Paginator;

    public function getPageItems(int $page): iterable;

    public function getCurrentPage(): int;

    public function getTotalPages(): int;
}
