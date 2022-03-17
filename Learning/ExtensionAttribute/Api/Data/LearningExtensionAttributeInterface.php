<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Api\Data;

use Learning\ExtensionAttribute\Model\LearningExtensionAttribute;

interface LearningExtensionAttributeInterface
{
    const TEXT = 'text';
    const PRODUCT_ID = 'id';

    public function getText(): string;

    public function setText(string $text): LearningExtensionAttribute;

    public function getProductId(): int;

    public function setProductId(int $productId): LearningExtensionAttribute;
}
