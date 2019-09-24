<?php

namespace SwagAdvDevBundle1\Models;

use Doctrine\ORM\Mapping as ORM;
use Shopware\Components\Model\ModelEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="s_bundles", options={"collate"="utf8_unicode_ci"})
 */
class Bundle extends ModelEntity
{
    //todo Implement the columns id, active and name

    //todo Associate the product model (Shopware\Models\Article\Article) using a @ORM\ManyToMany association
    //todo Important: The intermediate table should be called s_bundle_products.  Its columns are bundle_id, product_id

    //todo https://developers.shopware.com/developers-guide/backend-components/associations/
}
