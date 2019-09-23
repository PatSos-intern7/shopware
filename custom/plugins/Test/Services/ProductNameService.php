<?php

namespace Test\Services;

use Doctrine\DBAL\Connection;

class ProductNameService
{
    /** @var Connection */
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getProductsNames(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $result = $queryBuilder->select('name')
            ->from('s_articles')
            ->setMaxResults(20)
            ->execute();

        $productNames = $result->fetchAll(\PDO::FETCH_COLUMN);
        return $productNames;
    }
}
