<?php
namespace VirtuaTechnology\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Controller_ActionEventArgs;
use Enlight_Event_EventArgs;
use VirtuaTechnology\Services\TechnologyService;
use VirtuaTechnology\VirtuaTechnology;

class Frontend implements SubscriberInterface
{
    /**
     * @var TechnologyService
     */
    private $technologyService;

    public function __construct(TechnologyService $technologyService)
    {
        $this->technologyService = $technologyService;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Frontend_Technology' => 'onPreDispatch',
            'Shopware_Components_RewriteGenerator_FilterQuery' => 'filterParameterQuery'
        ];
    }

    public function onPreDispatch(Enlight_Controller_ActionEventArgs $args)
    {
        $config = $this->technologyService->getPluginConfig();
        if($config['Display Featured Products']) {
            $featuredProducts = $this->technologyService->getArticlesData();
            $view = $args->getSubject()->View();
            $view->assign('featuredProducts', $this->technologyService->prepDataForView($featuredProducts));
        }
        die('oko');
    }

    public function filterParameterQuery(\Enlight_Event_EventArgs $args)
    {
        $orgQuery = $args->getReturn();
        $query = $args->getQuery();

        if ($query['controller'] === 'glossary' && isset($query['wordId'])) {
            $orgQuery['wordId'] = $query['wordId'];
        }

        return $orgQuery;
    }
}
