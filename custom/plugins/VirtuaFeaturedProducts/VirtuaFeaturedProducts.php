<?php

namespace VirtuaFeaturedProducts;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class VirtuaFeaturedProducts extends Plugin
{
        public function install(InstallContext $context)
        {
            $attributeService = $this->container->get('shopware_attribute.crud_service');
            $attributeService->update('s_articles_attributes','is_featured','boolean',[
                'displayInBackend'=>true,
                'label'=>'Is Featured'
            ],null,false,false);

            $this->container->get('models')->generateAttributeModels(['s_articles_attributes']);
            $context->scheduleClearCache(InstallContext::CACHE_LIST_DEFAULT);
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
