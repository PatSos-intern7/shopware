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
                'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'addTemplateDir',
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
            $context->scheduleClearCache(InstallContext::CACHE_LIST_DEFAULT);
        }

        public function uninstall(UninstallContext $context)
        {
            if($context->keepUserData()){
                return;
            }

            $context->scheduleClearCache(InstallContext::CACHE_LIST_DEFAULT);
        }
}
