<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Block\Product;

use Magento\Catalog\Block\Product\View as Template;

class View extends Template
{
    /**
     * @return array
     */
    public function getDescriptions(): array
    {
        $descriptions = [];
        $extensionAttributes = $this->getProduct()->getExtensionAttributes()->getLearningExtensionAttribute();
        if (empty($extensionAttributes)) {
            return $descriptions;
        }
        foreach ($extensionAttributes as $attribute) {
            $descriptions[] = $attribute->getData('description');
        }
        return $descriptions;
    }
}
