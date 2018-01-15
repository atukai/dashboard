<?php

namespace Gridly\Source;

use Doctrine\Common\Collections\Collection;
use Gridly\Schema;

class DoctrineCollections implements Source
{
    /** @var Collection  */
    private $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }
    
    public function applySchema(Schema\Schema $schema): void
    {
        // TODO: Implement applySchema() method.
    }
    
    public function filter(?array $filters = []): Source
    {
        if (empty($filters)) {
            return $this;
        }

        return $this;
    }

    public function sort(string $columnName, string $direction): Source
    {
        return $this;
    }

    public function getItems(int $offset, int $limit): iterable
    {
        return $this->collection->slice($offset, $limit);
    }

    public function count(): int
    {
        return $this->collection->count();
    }
}
