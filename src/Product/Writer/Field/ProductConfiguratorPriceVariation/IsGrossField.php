<?php declare(strict_types=1);

namespace Shopware\Product\Writer\Field\ProductConfiguratorPriceVariation;

use Shopware\Framework\Validation\ConstraintBuilder;
use Shopware\Product\Writer\Api\IntField;

class IsGrossField extends IntField
{
    public function __construct(ConstraintBuilder $constraintBuilder)
    {
        parent::__construct('isGross', 'is_gross', 'product_configurator_price_variation', $constraintBuilder);
    }
}