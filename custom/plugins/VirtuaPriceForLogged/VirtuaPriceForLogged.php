<?php

namespace VirtuaPriceForLogged;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class VirtuaPriceForLogged extends Plugin
{
        /**
         * {@inheritdoc}
         */
        public static function getSubscribedEvents()
        {
            return [
                'Enlight_Controller_Action_PreDispatch_Frontend_Detail' => 'addTemplateDir',
            ];
        }

        /**
         * @param \Enlight_Controller_ActionEventArgs $args
         */
        public function addTemplateDir(\Enlight_Controller_ActionEventArgs $args)
        {
            $args->getSubject()->View()->addTemplateDir($this->getPath() . '/Resources/views');
        }

        public function install(InstallContext $context)
        {

        }

        public function uninstall(UninstallContext $context)
        {
            if($context->keepUserData()){
                return;
            }
            $attributeService = $this->container->get('shopware_attribute.crud_service');

            $attributeExist = $attributeService->get('s_articles_attributes','is_featured');

            if($attributeExist === NULL){
                return;
            }
            $attributeService->delete('s_articles_attributes','is_featured');
            $context->scheduleClearCache(InstallContext::CACHE_LIST_DEFAULT);
        }
}
