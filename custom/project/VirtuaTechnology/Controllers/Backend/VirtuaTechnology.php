<?php

use VirtuaTechnology\Models\Technology;

class Shopware_Controllers_Backend_VirtuaTechnology
extends Shopware_Controllers_Backend_Application
{
    protected $model = Technology::class;
    protected $alias = 'technology';

    public function save($data)
    {
        $slugService = $this->get('shopware.slug');
        $data['url'] = $slugService->slugify($data['name'],'-');
        return parent::save($data);
    }
}
