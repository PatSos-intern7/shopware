<?php

class Shopware_Controllers_Frontend_Technology extends Enlight_Controller_Action
{
    public function indexAction(): void
    {
        $request = $this->Request();

        $technologyPaginator = $this->get('virtua_technology.services.technology_paginator');
        $paginationData = $technologyPaginator->getPaginationData($request);

        $technologyService = $this->get('virtua_technology_services.technology_service');
        $technologies = $technologyService->getTechnologiesData($paginationData['offset'],$paginationData['perPage']);
        $this->View()->assign('techList',$technologies);
        $this->View()->assign('paginator', $paginationData);
    }
    public function detailAction(): void
    {
        $nameId = $this->Request()->getParam('nameId');
        $technologyService = $this->get('virtua_technology_services.technology_service');
        $technology = $technologyService->getTechnology($nameId);
        $this->View()->assign($technology);
    }
}
