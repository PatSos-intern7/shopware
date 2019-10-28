<?php
namespace VirtuaPriceForLogged\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Controller_ActionEventArgs;
use Shopware\Components\DependencyInjection\Container;

class Frontend implements SubscriberInterface
{
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Frontend'=>'onPreDispatch',
            'Enlight_Controller_Action_PreDispatch_Widgets'=>'onPreDispatch'
        ];
    }

    public function onPreDispatch(Enlight_Controller_ActionEventArgs $args): void
    {
        $user = $this->container->get('session')->get('sUserId');
        if($user){
            $args->getSubject()->View()->assign('logged',true);
            return;
        }

    }
}
