<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Model\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductSearchResultsInterface;
use Learning\ExtensionAttribute\Model\LearningExtensionAttribute;
use Learning\ExtensionAttribute\Model\ResourceModel\LearningExtensionAttribute\CollectionFactory;


class ExtensionAttributeGet
{
    private LearningExtensionAttribute $learningExtensionAttribute;
    private CollectionFactory $collectionFactory;

    public function __construct(
        LearningExtensionAttribute $learningExtensionAttribute,
        CollectionFactory $collectionFactory
    ) {
        $this->learningExtensionAttribute = $learningExtensionAttribute;
        $this->collectionFactory = $collectionFactory;
    }

    public function afterGet(
        ProductRepositoryInterface $subject,
        ProductInterface $entity
    ): ProductInterface {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('product_id', $entity->getId());
        $data = $collection->getItems();
//        $data = $this->learningExtensionAttribute->setText('Some text');


        $extensionAttributes = $entity->getExtensionAttributes();
        $extensionAttributes->setLearningExtensionAttribute($data);

        $entity->setExtensionAttributes($extensionAttributes);
        return $entity;
    }

    public function afterGetList(
        ProductRepositoryInterface $subject,
        ProductSearchResultsInterface $searchResults
    ): ProductSearchResultsInterface {
        $products = [];

        foreach ($searchResults->getItems() as $entity) {
            $data = $this->learningExtensionAttribute->setText('Some text');

            $extensionAttributes = $entity->getExtensionAttributes();
            $extensionAttributes->setLearningExtensionAttribute($data);
            $entity->setExtensionAttributes($extensionAttributes);

            $products[] = $entity;
        }

        $searchResults->setItems($products);
        return $searchResults;
    }
}
