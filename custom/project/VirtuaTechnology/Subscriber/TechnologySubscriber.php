<?php
namespace VirtuaTechnology\Subscriber;
use Enlight\Event\SubscriberInterface;
use Enlight_Controller_ActionEventArgs;
use Enlight_Event_EventArgs;
use Shopware\Models\Shop\Shop;

class TechnologySubscriber implements SubscriberInterface
{
    /**
     * @var \Enlight_Template_Manager
     */
    private $templateManager;

    /**
     * @param $pluginDirectory
     * @param \Enlight_Template_Manager $templateManager
     */
    public function __construct(\Enlight_Template_Manager $templateManager)
    {
        $this->templateManager = $templateManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Frontend' => 'registerViewDirectory',
            'Enlight_Controller_Action_PreDispatch_Frontend_Detail' =>'technologyTab'

        ];
    }
    public function registerViewDirectory(Enlight_Controller_ActionEventArgs $args)
    {
        $pluginBasePath = Shopware()->Container()->getParameter('virtua_technology.plugin_dir');
        $this->templateManager->addTemplateDir($pluginBasePath.'/Resources/views');
        $this->templateManager->addTemplateDir($pluginBasePath.'/Resources/snippets');
    }

    public function technologyTab(Enlight_Controller_ActionEventArgs $args)
    {
        $technologyService = Shopware()->Container()->get('virtua_technology_services.technology_service');
        $articlesApi = Shopware()->Container()->get('shopware.api.article');

        $articleId = $args->getRequest()->getParam('sArticle');
        $oneArticle = $articlesApi->getOne($articleId);

        $technologyList = $this->prepTechnologyTabData($oneArticle, $technologyService);

        $this->templateManager->assign('techList',$technologyList);
    }

    /**
     * @param $oneArticle
     * @param $techService
     * @return array
     */
    private function prepTechnologyTabData($oneArticle, $techService): array
    {
        $techs = $oneArticle['mainDetail']['attribute']['technology'];
        if($techs) {
            $techArray = explode('|', $techs);
            $techArray = array_filter($techArray);

            $technologyList = [];
            foreach ($techArray as $tech) {
                $technologyList[] = $techService->getTechnology($tech);
            }
        } else {
            $technologyList = [];
        }
        return $technologyList;
    }
}
