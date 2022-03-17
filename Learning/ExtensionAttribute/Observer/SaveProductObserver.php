<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Learning\ExtensionAttribute\Model\ResourceModel\LearningExtensionAttribute\CollectionFactory;

class SaveProductObserver implements ObserverInterface
{
    private CollectionFactory $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function execute(Observer $observer)
    {
        $product = $observer->getData('product');
        $collection = $this->collectionFactory->create();
        foreach ($product->getExtensionAttributes()->getLearningExtensionAttribute() as $attribute) {
//            $collection->addItem($attribute);
        }
        $collection->save();
    }
}
