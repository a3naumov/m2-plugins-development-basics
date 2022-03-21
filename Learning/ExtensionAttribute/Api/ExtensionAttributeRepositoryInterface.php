<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Api;

use Learning\ExtensionAttribute\Model\LearningExtensionAttribute;
use Learning\ExtensionAttribute\Api\Data\LearningExtensionAttributeInterface;

interface ExtensionAttributeRepositoryInterface
{
    /**
     * @param int $id
     * @return LearningExtensionAttribute
     */
    public function getById(int $id): LearningExtensionAttribute;

    /**
     * @param int $product_id
     * @return LearningExtensionAttribute
     */
    public function getByProductId(int $product_id): LearningExtensionAttribute;

    /**
     * @param LearningExtensionAttributeInterface $learningExtensionAttribute
     * @return bool
     */
    public function delete(LearningExtensionAttributeInterface $learningExtensionAttribute): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

    /**
     * @param int $product_id
     * @return bool
     */
    public function deleteByProductId(int $product_id): bool;
}
