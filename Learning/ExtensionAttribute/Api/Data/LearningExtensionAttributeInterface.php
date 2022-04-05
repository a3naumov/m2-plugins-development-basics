<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Api\Data;

use Learning\ExtensionAttribute\Model\LearningExtensionAttribute;

interface LearningExtensionAttributeInterface
{
    const DESCRIPTION = 'description';

    const PRODUCT_ID = 'product_id';

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @param string $description
     * @return LearningExtensionAttribute
     */
    public function setDescription(string $description): LearningExtensionAttribute;

    /**
     * @return int
     */
    public function getProductId(): int;

    /**
     * @param int $productId
     * @return LearningExtensionAttribute
     */
    public function setProductId(int $productId): LearningExtensionAttribute;
}
