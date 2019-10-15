<?php

class Shopware_Controllers_Widgets_SwagBundle extends Enlight_Controller_Action
{
    public function addBundleAction()
    {
        // todo: for a given bundleId: get all related product order numbers and add those to the basket
        // reuse a method from your bundle service to get the product numbers
        // redirect to checkout/cart afterwards

        $bundleId = $this->request->getParam('bundleId');

        if(!$bundleId){
            throw new Exception('No bundle id given');
        }
        $bundleService = $this->container->get('swag_bundle.bundle_service');
        $productNumbers = $bundleService->getProductNumbersByBundleId($bundleId);

        /** @var Shopware_Components_Modules $moduleManager */
        $moduleManager = $this->container->get('modules');

        /** @var sBasket $basket */
        $basket = $moduleManager->getModule('Basket');

        foreach ($productNumbers as $productNumber){
            $basket->sAddArticle($productNumber);
        }

        $this->redirect(
            [
                'controller'=>'checkout',
                'action'=>'cart'
            ]
        );
    }
}
