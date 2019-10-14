<?php

namespace VirtuaTechnology;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class VirtuaTechnology extends Plugin
{
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_CronJob_RefreshSeoIndex_CreateRewriteTable' => 'createGlossaryRewriteTable',
            'sRewriteTable::sCreateRewriteTable::after' => 'createGlossaryRewriteTable',
            'Enlight_Controller_Action_PostDispatch_Backend_Performance' => 'loadPerformanceExtension',
            'Shopware_Controllers_Seo_filterCounts' => 'addGlossaryCount',
            'Shopware_Components_RewriteGenerator_FilterQuery' => 'filterParameterQuery'
        ];
    }

    public function install(InstallContext $context)
    {
        $dbalConnection = $this->container->get('dbal_connection');
        $dbalConnection->exec(
            'create table IF NOT EXISTS `s_virtua_technology`
            (
                `id` int NOT NULL auto_increment primary key,
                `name` varchar(255) not null,
                `description` longtext  null,
                `logo`        longtext  null,
                `url`         longtext  null
            );'
        );

        $dbalConnection->exec(
            'INSERT IGNORE INTO `s_virtua_technology` (`id`,`name`,`description`,`logo`,`url`) 
                       VALUES
                        (9, \'45645\', \'65465465\', \'782\', \'45645\'),
                        (10, \'4545\', \'56546545\', \'780\', \'4545\');
        ');
        parent::install($context);
    }

    public function uninstall(UninstallContext $context)
    {
        if (!$context->keepUserData()) {
            /** @var Connection $dbalConnection */
            $dbalConnection = $this->container->get('dbal_connection');
            $dbalConnection->exec('DROP TABLE s_virtua_technology');
        }
        parent::uninstall($context);
    }
}
