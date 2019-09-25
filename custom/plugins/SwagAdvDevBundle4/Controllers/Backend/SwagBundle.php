<?php

use SwagAdvDevBundle4\Models\Bundle;

class Shopware_Controllers_Backend_SwagBundle extends Shopware_Controllers_Backend_Application
{
    protected $model = Bundle::class;
    protected $alias = 'bundle';

    //todo overwrite the getDetailQuery method in order to have products in the bundle detail view
}
