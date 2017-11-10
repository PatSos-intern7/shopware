<?php declare(strict_types=1);

namespace Shopware\OrderDelivery\Searcher;

use Doctrine\DBAL\Connection;
use Shopware\Api\Search\Criteria;
use Shopware\Api\Search\Parser\SqlParser;
use Shopware\Api\Search\QueryBuilder;
use Shopware\Api\Search\Searcher;
use Shopware\Api\Search\SearchResultInterface;
use Shopware\Api\Search\UuidSearchResult;
use Shopware\Context\Struct\TranslationContext;
use Shopware\OrderDelivery\Factory\OrderDeliveryDetailFactory;
use Shopware\OrderDelivery\Reader\OrderDeliveryBasicReader;

class OrderDeliverySearcher extends Searcher
{
    /**
     * @var OrderDeliveryDetailFactory
     */
    private $factory;

    /**
     * @var OrderDeliveryBasicReader
     */
    private $reader;

    public function __construct(Connection $connection, SqlParser $parser, OrderDeliveryDetailFactory $factory, OrderDeliveryBasicReader $reader)
    {
        parent::__construct($connection, $parser);
        $this->factory = $factory;
        $this->reader = $reader;
    }

    protected function createQuery(Criteria $criteria, TranslationContext $context): QueryBuilder
    {
        return $this->factory->createSearchQuery($criteria, $context);
    }

    protected function load(UuidSearchResult $uuidResult, Criteria $criteria, TranslationContext $context): SearchResultInterface
    {
        $collection = $this->reader->readBasic($uuidResult->getUuids(), $context);

        $result = new OrderDeliverySearchResult($collection->getElements());

        $result->setTotal($uuidResult->getTotal());
        $result->setCriteria($criteria);
        $result->setContext($context);

        return $result;
    }
}