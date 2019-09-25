<?php

namespace SwagAdvDevBundle5\Bundle\StoreFrontBundle;

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
        //TODO return array of bundle structs
        // if the array is empty the product is not in a bundle
    }
}
