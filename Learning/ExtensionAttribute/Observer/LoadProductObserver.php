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
    /**
     * Field in DB for filter collection
     */
    private const ATTRIBUTE = 'product_id';

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $product = $observer->getEvent()->getProduct();
        $collection = $this->getFilteredCollection($product);
        $this->setAttributeData($collection, $product);
    }

    /**
     * @param ProductInterface $entity
     * @return Collection
     */
    private function getFilteredCollection(ProductInterface $entity): Collection
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(self::ATTRIBUTE, $entity->getId());
        return $collection;
    }

    /**
     * @param Collection $collection
     * @param ProductInterface $entity
     * @return void
     */
    private function setAttributeData(Collection $collection, ProductInterface $entity): void
    {
        $extensionAttributes = $entity->getExtensionAttributes();
        $extensionAttributes->setLearningExtensionAttribute($collection->getItems());
        $entity->setExtensionAttributes($extensionAttributes);
    }
}
