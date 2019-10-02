<?php

namespace VirtuaFeaturedProducts\Subscriber;

use Doctrine\DBAL\Connection;
use Enlight\Event\SubscriberInterface;
use PDO;
use Shopware\Components\DependencyInjection\Container;

class Frontend implements SubscriberInterface
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var array|false
     */
    private $pluginConfig;

    public function __construct(Container $container, Connection $connection)
    {
        $this->connection = $connection;
        $this->container = $container;
        $this->pluginConfig = $this->getPluginConfig();
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Frontend' => 'onPreDispatch',
//            'Enlight_Controller_Action_PreDispatch_Frontend_Detail' => 'addTemplateDir',
        ];
    }

    public function onPreDispatch()
    {
        var_dump($this->getPluginConfig());
        var_dump($this->getFeaturedArticlesId());
        //die('ook');
    }

//    /**
//     * @param \Enlight_Controller_ActionEventArgs $args
//     */
//    public function addTemplateDir(\Enlight_Controller_ActionEventArgs $args)
//    {
//        $this->container->get('VirtuaFeaturedProducts');
//        $args->getSubject()->View()->addTemplateDir($this->getPath() . '/Resources/views');
//    }

    public function getFeaturedArticlesId(): array
    {
        $maxResults = $this->pluginConfig['Number of products'];
        $queryBuilder = $this->connection->createQueryBuilder();
        $query = $queryBuilder->select('id')
            ->from('s_articles_attributes', 'saa')
            ->andWhere('saa.is_featured = :featured')
            ->setParameter('featured', true)
            ->setMaxResults($maxResults);
        $result = $query->execute();
        return $result->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getPluginConfig()
    {
        $config = $this->container->get('shopware.plugin.cached_config_reader')->getByPluginName('VirtuaFeaturedProducts');
        return $config;
    }
}
