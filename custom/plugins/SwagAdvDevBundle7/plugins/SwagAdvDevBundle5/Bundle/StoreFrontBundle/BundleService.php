<?php

namespace SwagAdvDevBundle5\Bundle\StoreFrontBundle;

use Doctrine\DBAL\Connection;
use Shopware\Bundle\StoreFrontBundle\Service\ListProductServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
use Shopware\Components\Compatibility\LegacyStructConverter;
use SwagAdvDevBundle5\Bundle\StoreFrontBundle\Struct\Bundle;

class BundleService
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var ListProductServiceInterface
     */
    private $listProductService;

    /**
     * @var LegacyStructConverter
     */
    private $structConverter;

    /**
     * @param Connection                  $connection
     * @param ListProductServiceInterface $listProductService
     * @param LegacyStructConverter       $structConverter
     */
    public function __construct(
        Connection $connection,
        ListProductServiceInterface $listProductService,
        LegacyStructConverter $structConverter
    ) {
        $this->connection = $connection;
        $this->listProductService = $listProductService;
        $this->structConverter = $structConverter;
    }

    /**
     * @param string               $productId
     * @param ShopContextInterface $context
     *
     * @return Struct\Bundle[]
     */
    public function getProductBundles($productId, ShopContextInterface $context)
    {
        //TODO return array of bundle structs
        // if the array is empty the product is not in a bundle
        return $this->getBundlesByProductId($productId);
    }

    private function getBundlesByProductId($productId)
    {
        $builder = $this->connection->createQueryBuilder();

        $builder->select(['id', 'name'])
            ->from('s_bundle_products', 'bundleProducts')
            ->innerJoin('bundleProducts', 's_bundles', 'bundles', 'bundleProducts.bundle_id = bundles.id')
            ->where('bundleProducts.product_id = :product_id')
            ->setParameter('product_id', $productId);

        $result = $builder->execute()->fetchAll();

        $bundles = [];

        foreach($result as $row) {
            $bundle = new Bundle();

            $bundle->setId($row['id']);
            $bundle->setName($row['name']);

            $bundles[] = $bundle;
        }

        return $bundles;
    }
}
