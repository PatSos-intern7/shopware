<?php
namespace VirtuaTechnology\Services;

use Doctrine\DBAL\Connection;

class TechnologyService
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(
        Connection $connection
    ) {
        $this->connection = $connection;
    }

    public function getTechnologiesData()
    {
        $builder = $this->connection->createQueryBuilder();
        $query = $builder->select('svt.name, svt.description, path, url')
            ->from('s_virtua_technology','svt')
            ->leftJoin('svt','s_media','sm','svt.logo = sm.id')
            ->execute()
            ->fetchAll();

        return $query;
    }

    public function getTechnology($nameId)
    {
        $builder = $this->connection->createQueryBuilder();
        $techData = $builder->select('svt.name, svt.description, path')
            ->from('s_virtua_technology', 'svt')
            ->leftJoin('svt','s_media','sm','svt.logo = sm.id')
            ->where('svt.id = :id')
            ->setParameter(':id', $nameId)
            ->execute()
            ->fetch();

        return $techData;
    }
}
