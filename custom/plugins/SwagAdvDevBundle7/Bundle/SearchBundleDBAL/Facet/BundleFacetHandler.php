<?php

namespace SwagAdvDevBundle7\Bundle\SearchBundleDBAL\Facet;

use Shopware\Bundle\SearchBundle\Criteria;
use Shopware\Bundle\SearchBundle\FacetInterface;
use Shopware\Bundle\SearchBundleDBAL\FacetHandlerInterface;
use Shopware\Bundle\SearchBundleDBAL\PartialFacetHandlerInterface;
use Shopware\Bundle\SearchBundleDBAL\QueryBuilderFactory;
use Shopware\Bundle\StoreFrontBundle\Struct;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;

class BundleFacetHandler implements FacetHandlerInterface, PartialFacetHandlerInterface
{
    /**
     * @var QueryBuilderFactory
     */
    private $queryBuilderFactory;

    /**
     * @param QueryBuilderFactory $queryBuilderFactory
     */
    public function __construct(QueryBuilderFactory $queryBuilderFactory)
    {
        $this->queryBuilderFactory = $queryBuilderFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsFacet(FacetInterface $facet)
    {
        //todo check if facet is your bundle facet.
    }

    /**
     * {@inheritdoc}
     */
    public function generateFacet(
        FacetInterface $facet,
        Criteria $criteria,
        Struct\ShopContextInterface $context
    ) {
        // todo clone the criteria object
        // todo reset the conditions and sortings of the cloned criteria
        // todo call and return the result of the generatePartialFacet() method
    }

    /**
     * {@inheritdoc}
     */
    public function generatePartialFacet(
        FacetInterface $facet,
        Criteria $reverted,
        Criteria $criteria,
        ShopContextInterface $context
    ) {
        //todo (development) return a new BooleanFacetResult without checking if products with bundles occurred

        //todo generate the query over the queryBuilderFactory
        //todo extend the query to select if products has bundles
        //todo return BooleanFacetResult if bundles exists
        //todo return NULL if there no bundle product in the listing
        //todo BooleanFacetResult should have "bundle" as formFieldName
    }
}
