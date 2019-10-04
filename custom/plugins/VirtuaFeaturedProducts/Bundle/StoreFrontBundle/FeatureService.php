<?php
namespace VirtuaFeaturedProducts\Bundle\StoreFrontBundle;

use Doctrine\DBAL\Connection;
use PDO;
use Shopware\Bundle\StoreFrontBundle\Service\ListProductServiceInterface;
use Shopware\Components\DependencyInjection\Container;

class FeatureService
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var ListProductServiceInterface
     */
    public $listProductService;

    /**
     * @var array|false
     */
    public $pluginConfig;
    /**
     * @var Container
     */
    private $container;

    /**
     * @param Connection $connection
     * @param Container $container
     * @param ListProductServiceInterface $listProductService
     */
    public function __construct(
        Connection $connection,
        Container $container,
        ListProductServiceInterface $listProductService
    ) {
        $this->connection = $connection;
        $this->container = $container;
        $this->listProductService = $listProductService;
        $this->pluginConfig = $this->getPluginConfig();
    }

    public function getFeaturedArticlesId(): array
    {
        $maxResults = $this->pluginConfig['Number of products'];
        $queryBuilder = $this->connection->createQueryBuilder();
        $query = $queryBuilder->select('sad.ordernumber')
            ->from('s_articles_attributes', 'saa')
            ->leftJoin('saa','s_articles_details','sad','saa.articledetailsID = sad.id')
            ->andWhere('saa.is_featured = true')
            ->setMaxResults($maxResults);
        $result = $query->execute();
        return $result->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getArticlesData(): array
    {
        $context = $this->container->get('shopware_storefront.context_service')->getShopContext();
        $ids = $this->getFeaturedArticlesId();
        return $this->listProductService->getList($ids, $context);
    }

    public function getPluginConfig()
    {
        $config = $this->container->get('shopware.plugin.cached_config_reader')->getByPluginName('VirtuaFeaturedProducts');
        return $config;
    }

    public function prepDataForView($data): array
    {
        $result =[];
        foreach($data as $key=>$product){
            if($product->getCover() !== null) {
                $result[$key]['articleName'] = $product->getName();
                $result[$key]['price'] = $product->getPrices()[0]->getCalculatedPrice();
                $result[$key]['image']['thumbnails'][0]['sourceSet'] = $product->getCover()->getThumbnail(0)->getSource();
            }
        }
        return $result;
    }

}
