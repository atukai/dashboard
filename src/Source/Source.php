<?php

namespace Gridly\Source;

use Countable;
use Gridly\Schema;
use Gridly\Source\Filter\Filter;

interface Source extends Countable
{
    /**
     * @param int $offset
     * @param int $limit
     * @return iterable
     */
    public function getItems(int $offset, int $limit): iterable;
    
    /**
     * @param Schema\Schema $schema
     */
    public function applySchema(Schema\Schema $schema): void;
    
    /**
     * @param Filter[] $filters
     * @return Source
     */
    public function filter(array $filters = []): Source;
    
    /**
     * @param string $columnName
     * @param string $direction
     * @return Source
     */
    public function sort(string $columnName, string $direction): Source;
}
