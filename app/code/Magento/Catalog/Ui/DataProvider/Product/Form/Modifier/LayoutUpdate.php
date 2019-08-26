<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\Catalog\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

/**
 * Additional logic on how to display the layout update field.
 */
class LayoutUpdate implements ModifierInterface
{
    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @param LocatorInterface $locator
     */
    public function __construct(LocatorInterface $locator)
    {
        $this->locator = $locator;
    }

    /**
     * @inheritdoc
     * @since 101.1.0
     */
    public function modifyData(array $data)
    {
        $product = $this->locator->getProduct();
        if ($oldLayout = $product->getCustomAttribute('custom_layout_update')) {
            if ($oldLayout->getValue()) {
                $data[$product->getId()][AbstractModifier::DATA_SOURCE_DEFAULT]['custom_layout_update_file']
                    = '__existing__';
            }
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function modifyMeta(array $meta)
    {
        return $meta;
    }
}
