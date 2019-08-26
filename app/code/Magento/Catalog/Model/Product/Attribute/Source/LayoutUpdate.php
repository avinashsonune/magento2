<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\Catalog\Model\Product\Attribute\Source;

use Magento\Catalog\Model\Product\Attribute\LayoutUpdateManager;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Eav\Model\Entity\Attribute\Source\SpecificSourceInterface;
use Magento\Framework\Api\CustomAttributesDataInterface;

/**
 * List of layout updates available for a product.
 */
class LayoutUpdate extends AbstractSource implements SpecificSourceInterface
{
    /**
     * @var string[]
     */
    private $optionsText;

    /**
     * @var LayoutUpdateManager
     */
    private $manager;

    /**
     * @param LayoutUpdateManager $manager
     */
    public function __construct(LayoutUpdateManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @inheritDoc
     */
    public function getAllOptions()
    {
        $default = '';
        $defaultText = 'Use default';
        $this->optionsText[$default] = $defaultText;

        return [['label' => $defaultText, 'value' => $default]];
    }

    /**
     * @inheritDoc
     */
    public function getOptionText($value)
    {
        if (is_scalar($value) && array_key_exists($value, $this->optionsText)) {
            return $this->optionsText[$value];
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function getOptionsFor(CustomAttributesDataInterface $entity): array
    {
        $options = $this->getAllOptions();
        if ($entity->getCustomAttribute('custom_layout_update')) {
            $existingValue = '__existing__';
            $existingLabel = 'Use existing';
            $options[] = ['label' => $existingLabel, 'value' => $existingValue];
            $this->optionsText[$existingValue] = $existingLabel;
        }
        foreach ($this->manager->fetchAvailableFiles($entity) as $handle) {
            $options[] = ['label' => $handle, 'value' => $handle];
            $this->optionsText[$handle] = $handle;
        }

        return $options;
    }
}
