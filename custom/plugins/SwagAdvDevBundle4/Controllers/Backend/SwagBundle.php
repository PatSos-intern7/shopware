<?php

use SwagAdvDevBundle4\Models\Bundle;

class Shopware_Controllers_Backend_SwagBundle extends Shopware_Controllers_Backend_Application
{
    protected $model = Bundle::class;
    protected $alias = 'bundle';

    //todo overwrite the getDetailQuery method in order to have products in the bundle detail view
    protected function getDetailQuery($id)
    {
        $builder = parent::getDetailQuery($id); // TODO: Change the autogenerated stub
        $builder->leftJoin('bundle.products','products')
            ->addSelect('products');
        return $builder;
    }
}