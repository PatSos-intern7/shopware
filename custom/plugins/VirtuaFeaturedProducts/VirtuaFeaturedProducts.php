<?php

namespace VirtuaFeaturedProducts;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class VirtuaFeaturedProducts extends Plugin
{

        /**
         * {@inheritdoc}
         */
        public static function getSubscribedEvents()
        {
            return [
                'Enlight_Controller_Action_PreDispatch_Frontend_Detail' => 'addTemplateDir',
                //todo listing extension (filter)
                //  todo add filter
                // add facet in SwagAdvDevBundle7\Bundle\SearchBundle\CriteriaRequestHandler
                // implement SwagAdvDevBundle7\Bundle\SearchBundleDBAL\Facet\BundleFacetHandler
                // a new filter should be available in listing
                // check for request parameter in CriteriaRequestHandler and add the condition
                // implement SwagAdvDevBundle7\Bundle\SearchBundleDBAL\Condition\BundleConditionHandler
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
