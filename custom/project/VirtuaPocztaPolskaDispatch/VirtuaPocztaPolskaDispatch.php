<?php
namespace VirtuaPocztaPolskaDispatch;

use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin;


class VirtuaPocztaPolskaDispatch extends Plugin
{
    public function install(InstallContext $installContext)
    {
        $dispatchCreator  = Shopware()->Container()->get('virtua_poczta_polska_dispatch.services.dispatch_creator');
        $dispatchCreator->createDeliveryMethod();

        $installContext->scheduleClearCache(InstallContext::CACHE_LIST_DEFAULT);
    }
}
