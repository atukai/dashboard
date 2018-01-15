<?php

namespace Gridly\Source;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Gridly\Schema;
use Gridly\Source\Filter\Exception;
use Gridly\Source\Filter\Filter;
use function is_array;

class DoctrineDbal implements Source
{
    /** @var QueryBuilder  */
    private $queryBuilder;

    public function __construct(Connection $dbal, string $tableName)
    {
        $this->queryBuilder = $dbal->createQueryBuilder();
        $this->queryBuilder
            ->select('*')
            ->from($tableName);
    }
    
    public function applySchema(Schema\Schema $schema): void
    {
        // TODO: Implement applySchema() method.
    }
    
    /**
     * @param array|null $filters
     * @return Source
     * @throws Exception
     */
    public function filter(?array $filters = []): Source
    {
        if (empty($filters)) {
            return $this;
        }

        /** @var Filter $filter */
        foreach ($filters as $i => $filter) {
            switch ($filter->getOperand()) {
                case Filter::OP_EQUAL:
                    $value = $filter->getValue();
                    if (is_array($value)) {
                        $this->queryBuilder->where(
                            $this->queryBuilder->expr()->in($filter->getColumnName(), $value)
                        );
                    } else {
                        $this->queryBuilder->where(
                            $this->queryBuilder->expr()->eq($filter->getColumnName(), $value)
                        );
                    }
                    break;
                case Filter::OP_LIKE:
                    $this->queryBuilder->where(
                        $this->queryBuilder->expr()->like($filter->getColumnName(), '"%' . $filter->getValue() . '%"')
                    );

                    break;
                default:
                    Exception::onUnsupportedFilterOperand(
                        $filter->getOperand(),
                        self::class
                    );
            }
        }

        return $this;
    }

    public function sort(string $columnName, string $direction): Source
    {
        $this->queryBuilder->orderBy($columnName, $direction);

        return $this;
    }
    
    /**
     * @param int $offset
     * @param int $limit
     * @return iterable
     * @throws \Doctrine\DBAL\Exception
     */
    public function getItems(int $offset, int $limit): iterable
    {
        $this->queryBuilder
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $this->queryBuilder->execute()->fetchAllNumeric();
    }
    
    /**
     * @return int
     * @throws \Doctrine\DBAL\Exception
     */
    public function count(): int
    {
        $countQueryBuilder = clone $this->queryBuilder;
        $countQueryBuilder->select('COUNT(*)')
            ->setFirstResult(0)
            ->setMaxResults(null);

        return (int)$countQueryBuilder->execute()->fetchOne();
    }
}
