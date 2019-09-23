<?php

namespace Test\Subscribers;

use Enlight\Event\SubscriberInterface;

class FrontendRoutingSubscriber implements SubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Frontend_Test'=>'onPreTest',
        ];
        // TODO: Implement getSubscribedEvents() method.
    }

    public function onPreTest(\Enlight_Event_EventArgs $args): void
    {
        /** @var \Shopware_Controllers_Frontend_Test $subject */
        $controller = $args->getSubject();

        //Register
        $controller->View()->addTemplateDir(__DIR__.'/Resources/views');
    }
}
