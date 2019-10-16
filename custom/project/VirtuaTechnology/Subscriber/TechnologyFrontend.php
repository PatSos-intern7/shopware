<?php
namespace VirtuaTechnology\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Controller_ActionEventArgs;
use Enlight_Event_EventArgs;
use VirtuaTechnology\Services\TechnologyService;

class TechnologyFrontend implements SubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatch_Frontend_Technology' => 'onPreDispatch',
            'Shopware_Components_RewriteGenerator_FilterQuery' => 'filterParameterQuery'

        ];
    }

    public function onPreDispatch(Enlight_Controller_ActionEventArgs $args)
    {

    }

    public function filterParameterQuery(\Enlight_Event_EventArgs $args)
    {
        $orgQuery = $args->getReturn();
        $query = $args->getQuery();

        if ($query['controller'] === 'technology' && isset($query['techId'])) {
            $orgQuery['techId'] = $query['techId'];
        }

        return $orgQuery;
    }
}
