<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Learning\ExtensionAttribute\Model\ResourceModel\LearningExtensionAttribute\Collection;
use Learning\ExtensionAttribute\Model\ResourceModel\LearningExtensionAttribute\CollectionFactory;

class LoadProductObserver implements ObserverInterface
{
    private const ATTRIBUTE = 'product_id';

    private CollectionFactory $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    public function execute(Observer $observer): void
    {
        $product = $observer->getData('product');
        $collection = $this->getFilteredCollection($product);
        $this->setAttributeData($collection, $product);
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
