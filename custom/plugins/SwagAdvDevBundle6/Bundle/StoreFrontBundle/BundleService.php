<?php

namespace SwagAdvDevBundle6\Bundle\StoreFrontBundle;

use Doctrine\DBAL\Connection;
use Shopware\Bundle\StoreFrontBundle\Service\ListProductServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
use Shopware\Components\Compatibility\LegacyStructConverter;

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
        $bundles = $this->getBundlesByProductId($productId);

        foreach ($bundles as $bundle){
            $productNumbers = $this->getProductNumbersByBundleId($bundle->getId());
            $products = $this->listProductService->getList($productNumbers, $context);
            $bundle->setProducts($products);

            $legacyProducts = $this->structConverter->convertListProductStructList($products);
            $bundle->setLegacyProducts($legacyProducts);
        }

        return $bundles;
    }

    /**
     * @param int $productId
     *
     * @return Struct\Bundle[]
     */
    private function getBundlesByProductId($productId)
    {
        $builder = $this->connection->createQueryBuilder();
        $builder->select(['id', 'name'])
            ->from('s_bundle_products', 'bundleProducts')
            ->innerJoin('bundleProducts', 's_bundles', 'bundles', 'bundles.id = bundleProducts.bundle_id')
            ->andWhere('bundleProducts.product_id = :productId')
            ->setParameter('productId', $productId);

        $result = $builder->execute()->fetchAll();
        $bundles = [];

        foreach ($result as $row) {
            $bundle = new Struct\Bundle();
            $bundle->setId($row['id']);
            $bundle->setName($row['name']);

            // TODO also add the product information to each bundle

            $bundles[] = $bundle;
        }

        return $bundles;
    }

    public function getProductNumbersByBundleId($bundleId)
    {
      $builder = $this->connection->createQueryBuilder();
      $builder->select('ordernumber')
          ->from('s_bundle_products', 'bundleProducts')
          ->leftJoin('bundleProducts','s_articles_details','details','bundleProducts.product_id = details.articleID')
          ->where('details.kind=1')
          ->andWhere('bundleProducts.bundle_id = :bundleId')
          ->setParameter('bundleId', $bundleId);

      return $builder->execute()->fetchAll(\PDO::FETCH_COLUMN);
    }
}
