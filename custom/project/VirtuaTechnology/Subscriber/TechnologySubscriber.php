<?php
namespace VirtuaTechnology\Subscriber;
use Enlight\Event\SubscriberInterface;
use Enlight_Controller_ActionEventArgs;
use Enlight_Event_EventArgs;

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
            'Enlight_Controller_Action_PreDispatch_Frontend_Technology' => 'registerViewDirectory'
        ];
    }
    public function registerViewDirectory(Enlight_Controller_ActionEventArgs $args)
    {
        $pluginBasePath = Shopware()->Container()->getParameter('virtua_technology.plugin_dir');
        $this->templateManager->addTemplateDir($pluginBasePath.'/Resources/views');

    }
}
