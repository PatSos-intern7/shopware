<?php

namespace VirtuaTechnology;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Tools\SchemaTool;
use Enlight_Controller_ActionEventArgs;
use Shopware\Components\Model\ModelManager;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use VirtuaTechnology\Models\Technology;

class VirtuaTechnology extends Plugin
{

    public static function getSubscribedEvents()
    {
        return [
            'Shopware_CronJob_RefreshSeoIndex_CreateRewriteTable' => 'createTechnologyRewriteTable',
            'sRewriteTable::sCreateRewriteTable::after' => 'createTechnologyRewriteTable',
            'Enlight_Controller_Action_PostDispatch_Backend_Performance' => 'loadPerformanceExtension',
            'Shopware_Controllers_Seo_filterCounts' => 'addGlossaryCount',
            'Enlight_Controller_Action_PreDispatch_Backend' =>'addTemplateDir'
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function install(InstallContext $installContext)
    {
        $this->addTechnologyMultiselect($installContext);

        $this->createDatabase();
        $this->insertTestData();
    }

    public function uninstall(UninstallContext $uninstallContext)
    {
        if (!$uninstallContext->keepUserData()) {
            $this->removeDatabase();
        }
    }

    public function addTemplateDir(Enlight_Controller_ActionEventArgs $args): void
    {
        $args->getSubject()->View()->addTemplateDir($this->getPath() . '/Resources/views/');
    }

    /**
     * {@inheritdoc}
     */
    public function activate(ActivateContext $activateContext)
    {
        $activateContext->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
    }

    private function createDatabase()
    {
        $modelManager = $this->container->get('models');
        $tool = new SchemaTool($modelManager);

        $classes = $this->getClasses($modelManager);

        $tool->updateSchema($classes, true); // make sure to use the save mode
    }

    private function removeDatabase(): void
    {
        $modelManager = $this->container->get('models');
        $tool = new SchemaTool($modelManager);

        $classes = $this->getClasses($modelManager);

        $tool->dropSchema($classes);
    }

    /**
     * @param ModelManager $modelManager
     * @return array
     */
    private function getClasses(ModelManager $modelManager): array
    {
        return [
            $modelManager->getClassMetadata(Technology::class)
        ];
    }

    private function insertTestData(): void
    {
        $dbalConnection = $this->container->get('dbal_connection');
        $dbalConnection->exec(
            'INSERT IGNORE INTO `s_virtua_technology` (`id`,`name`,`description`,`logo`,`url`) 
                       VALUES
                        (9, \'45645\', \'65465465\', \'782\', \'45645\'),
                        (10, \'4545\', \'56546545\', \'780\', \'4545\');
        ');
    }

    public function createTechnologyRewriteTable(): void
    {
        /** @var \sRewriteTable $rewriteTableModule */
        $rewriteTableModule = Shopware()->Container()->get('modules')->sRewriteTable();
        $rewriteTableModule->sInsertUrl('sViewport=technology', 'technology/');

        /** @var QueryBuilder $dbalQueryBuilder */
        $dbalQueryBuilder = $this->container->get('dbal_connection')->createQueryBuilder();

        $technologies = $dbalQueryBuilder->select('svt.id, svt.url')
            ->from('s_virtua_technology', 'svt')
            ->execute()
            ->fetchAll(\PDO::FETCH_KEY_PAIR);

        foreach ($technologies as $techId => $tech) {
            $rewriteTableModule->sInsertUrl('sViewport=technology&sAction=detail&nameId=' . $techId, 'technology/' . $tech);
        }
    }

    public function loadPerformanceExtension(\Enlight_Controller_ActionEventArgs $args)
    {
        $subject = $args->getSubject();
        $request = $subject->Request();

        if ($request->getActionName() !== 'load') {
            return;
        }
        $subject->View()->addTemplateDir($this->getPath() . '/Resources/views/');
    }

    public function addGlossaryCount(\Enlight_Event_EventArgs $args)
    {
        $counts = $args->getReturn();

        /** @var QueryBuilder $dbalQueryBuilder */
        $dbalQueryBuilder = $this->container->get('dbal_connection')->createQueryBuilder();
        $technologyCount = $dbalQueryBuilder->select('COUNT(svt.id)')
            ->from('s_virtua_technology', 'svt')
            ->execute()
            ->fetchAll(\PDO::FETCH_COLUMN);

        $counts['technology'] = $technologyCount;

        return $counts;
    }

    /**
     * @param InstallContext $installContext
     * @throws \Exception
     */
    private function addTechnologyMultiselect(InstallContext $installContext): void
    {
        $attributeService = $this->container->get('shopware_attribute.crud_service');

        $attributeService->update(
            's_articles_attributes',
            'my_multi_selection',
            'multi_selection',
            [
                'entity' => Technology::class,
                'displayInBackend' => true,
                'label' => 'My multi selection',
            ],
            null,
            true
        );

        $this->container->get('models')->generateAttributeModels(['s_articles_attributes']);
        $installContext->scheduleClearCache(InstallContext::CACHE_LIST_DEFAULT);
    }

}
