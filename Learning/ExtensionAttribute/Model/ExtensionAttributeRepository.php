<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Model;

use Learning\ExtensionAttribute\Api\ExtensionAttributeRepositoryInterface;
use Learning\ExtensionAttribute\Api\Data\LearningExtensionAttributeInterface;
use Learning\ExtensionAttribute\Model\ResourceModel\LearningExtensionAttribute as AttributeResourceModel;

class ExtensionAttributeRepository implements ExtensionAttributeRepositoryInterface
{
    private AttributeResourceModel $attributeResourceModel;
    private LearningExtensionAttributeFactory $learningExtensionAttributeFactory;

    public function __construct(
        AttributeResourceModel $attributeResourceModel,
        LearningExtensionAttributeFactory $learningExtensionAttributeFactory
    ) {
        $this->attributeResourceModel = $attributeResourceModel;
        $this->learningExtensionAttributeFactory = $learningExtensionAttributeFactory;
    }

    public function getById(int $id): LearningExtensionAttribute
    {
        $attribute = $this->learningExtensionAttributeFactory->create();
        $this->attributeResourceModel->load($attribute, $id, 'id');
        return $attribute;
    }

    public function getByProductId(int $product_id): LearningExtensionAttribute
    {
        $attribute = $this->learningExtensionAttributeFactory->create();
        $this->attributeResourceModel->load($attribute, $product_id, 'product_id');
        return $attribute;
    }

    public function delete(LearningExtensionAttributeInterface $learningExtensionAttribute): bool
    {
        $this->attributeResourceModel->delete($learningExtensionAttribute);
        return true;
    }

    public function deleteById(int $id): bool
    {
        $this->delete($this->getById($id));
        return true;
    }

    public function deleteByProductId(int $product_id): bool
    {
        $this->delete($this->getByProductId($product_id));
        return true;
    }
}
