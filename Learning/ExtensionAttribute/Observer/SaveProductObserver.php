<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Learning\ExtensionAttribute\Model\ResourceModel\LearningExtensionAttribute\CollectionFactory;

class SaveProductObserver implements ObserverInterface
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws \Exception
     */
    public function execute(Observer $observer): void
    {
        $product = $observer->getEvent()->getProduct();
        $collection = $this->collectionFactory->create();
        foreach ($product->getExtensionAttributes()->getLearningExtensionAttribute() as $attribute) {
            $collection->addItem($attribute);
        }
        $collection->save();
    }
}
