<?php
class Shopware_Controllers_Frontend_Test extends Enlight_Controller_Action
{
    public function preDispatch()
    {
        $controllerAction = $this->Request()->getActionName();
        if($controllerAction === 'index' && ($this->get('session')->get('sUserId') === null)){
                return $this->redirect([
                    'module'=>'frontend',
                    'controller'=>'account',
                    'action'=>'login',
                    'sTarget'=>'test',
                    'sTargetAction'=>'index'

                ]);
        }
        $this->view->addTemplateDir(__DIR__.'/../../Resources/views');
        //parent::preDispatch(); // TODO: Change the autogenerated stub

        $this->view->assign('currentAction', $controllerAction);
    }

    public function indexAction(): void
    {
        $productNameService = $this->get('test.services.product_name_service');
        $productNames = $productNameService->getProductsNames();
        $this->view->assign('productNames',$productNames);
        $this->view->assign('nextPage','second');
    }

    public function secondAction()
    {
        $this->view->assign('nextPage','index');
    }
}