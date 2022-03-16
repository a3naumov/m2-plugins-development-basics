<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Model\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class ExtensionAttributeSave
{
    public function afterSave(
        ProductRepositoryInterface $subject,
        ProductInterface $result,
        ProductInterface $entity
    ): ProductInterface {
        $extensionAttributes = $entity->getExtensionAttributes();
        $data = $extensionAttributes->getLearningExtensionAttribute();


        return $result;
    }
}
