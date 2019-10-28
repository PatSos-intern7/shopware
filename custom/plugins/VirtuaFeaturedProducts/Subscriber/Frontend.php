<?php
namespace VirtuaFeaturedProducts\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Controller_ActionEventArgs;
use VirtuaFeaturedProducts\Bundle\StoreFrontBundle\FeatureService;

class Frontend implements SubscriberInterface
{
    /**
     * @var FeatureService
     */
    private $featureService;

    public function __construct(FeatureService $featureService)
    {
        $this->featureService = $featureService;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Frontend' => 'onPreDispatch'
        ];
    }

    public function onPreDispatch(Enlight_Controller_ActionEventArgs $args)
    {
        $config = $this->featureService->getPluginConfig();
        if($config['Display Featured Products']) {
            $featuredProducts = $this->featureService->getArticlesData();
            $view = $args->getSubject()->View();
            $view->assign('featuredProducts', $this->featureService->prepDataForView($featuredProducts));
        }
    }
}
