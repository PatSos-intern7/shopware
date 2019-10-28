<?php
namespace VirtuaLowStockCron\Subscriber;

use Doctrine\DBAL\Connection;
use Enlight\Event\SubscriberInterface;
use PDO;
use VirtuaLowStockMail\Services\Sender as Sender;


class LowStockCronSubscriber implements SubscriberInterface
{
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var Sender
     */
    private $sender;

    /**
     * Frontend constructor.
     * @param Connection $connection
     * @param Sender $sender
     */
    public function __construct(Connection $connection, Sender $sender)
    {
        $this->connection = $connection;
        $this->sender = $sender;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_CronJob_VirtuaLowStockCron'=>'lowStock'
        ];
    }

    public function lowStock(): void
    {
        $pluginConfig = Shopware()->Container()->get('shopware.plugin.cached_config_reader')->getByPluginName('VirtuaLowStockMail');
        $ownerMail =  Shopware()->Config()->get('mail');

        $lowStockInfo = $this->getLowStockProducts($pluginConfig['Low stock Qty']);

        if($pluginConfig['Low stock alert'] === true && !empty($lowStockInfo)) {
            $lowStockProductList = $this->toStringProducts($lowStockInfo);
            $this->sender->sendMail('Low Stock Email Template',$ownerMail,$lowStockProductList);
        }
    }

    private function getLowStockProducts($stock): array
    {
        $builder = $this->connection->createQueryBuilder();

        return  $builder->select('ordernumber')
            ->from('s_articles_details','articles_details')
            ->where('articles_details.instock <= :stock')
            ->setParameter(':stock', $stock)
            ->execute()
            ->fetchAll(PDO::FETCH_COLUMN);
    }

    private function toStringProducts(array $data): string
    {
        $msg = 'List of low stock products: ';
        $list = implode(',',$data);
        return $msg . $list . '.';
    }
}
