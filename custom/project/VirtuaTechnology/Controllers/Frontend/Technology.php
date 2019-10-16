<?php

class Shopware_Controllers_Frontend_Technology extends Enlight_Controller_Action
{
    public function preDispatch()
    {
        $pluginBasePath = $this->container->getParameter('virtua_technology.plugin_dir');
        $this->view->addTemplateDir($pluginBasePath.'/Resources/views');
        parent::preDispatch();
    }

    public function indexAction()
    {
        $technologyService = $this->get('virtua_technology_services.technology_service');
        $technologies = $technologyService->getTechnologiesData();
        $this->View()->assign('techList',$technologies);
    }
    public function detailAction()
    {
        $nameId = $this->Request()->getParam('nameId');
        $technologyService = $this->get('virtua_technology_services.technology_service');
        $technology = $technologyService->getTechnology($nameId);
        $this->View()->assign($technology);
    }
}
