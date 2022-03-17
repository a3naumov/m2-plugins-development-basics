<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Model\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductSearchResultsInterface;
use Learning\ExtensionAttribute\Model\ResourceModel\LearningExtensionAttribute\Collection;
use Learning\ExtensionAttribute\Model\ResourceModel\LearningExtensionAttribute\CollectionFactory;

class ExtensionAttributePlugin
{
    private const ATTRIBUTE = 'product_id';

    private CollectionFactory $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    public function afterGet(
        ProductRepositoryInterface $subject,
        ProductInterface $entity
    ): ProductInterface {
        $collection = $this->getFilteredCollection($entity);
        $this->setAttributeData($collection, $entity);
        return $entity;
    }

    public function afterGetList(
        ProductRepositoryInterface $subject,
        ProductSearchResultsInterface $searchResults
    ): ProductSearchResultsInterface {
        $products = [];

        foreach ($searchResults->getItems() as $entity) {
            $collection = $this->getFilteredCollection($entity);
            $this->setAttributeData($collection, $entity);
            $products[] = $entity;
        }

        $searchResults->setItems($products);
        return $searchResults;
    }

    public function afterSave(
        ProductRepositoryInterface $subject,
        ProductInterface $result,
        ProductInterface $entity
    ): ProductInterface {
        $collection = $this->collectionFactory->create();
        $extensionAttributes = $entity->getExtensionAttributes()->getLearningExtensionAttribute();
        if (empty($extensionAttributes)) {
            return $result;
        }
        foreach ($extensionAttributes as $attribute) {
            $collection->addItem($attribute);
        }
        $collection->save();
        return $result;
    }

    private function getFilteredCollection(ProductInterface $entity): Collection
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(self::ATTRIBUTE, $entity->getId());
        return $collection;
    }

    private function setAttributeData(Collection $collection, ProductInterface $entity): void
    {
        $extensionAttributes = $entity->getExtensionAttributes();
        foreach ($collection->getItems() as $item) {
            $extensionAttributes->setLearningExtensionAttribute($item->getData());
        }
        $entity->setExtensionAttributes($extensionAttributes);
    }
}
