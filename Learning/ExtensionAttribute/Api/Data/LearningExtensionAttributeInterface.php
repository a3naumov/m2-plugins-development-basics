<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Api\Data;

use Learning\ExtensionAttribute\Model\LearningExtensionAttribute;

interface LearningExtensionAttributeInterface
{
    const DESCRIPTION = 'description';
    const PRODUCT_ID = 'product_id';

    public function getDescription(): string;

    public function setDescription(string $description): LearningExtensionAttribute;

    public function getProductId(): int;

    public function setProductId(int $productId): LearningExtensionAttribute;
}
