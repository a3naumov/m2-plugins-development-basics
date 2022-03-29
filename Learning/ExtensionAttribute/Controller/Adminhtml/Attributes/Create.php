<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Controller\Adminhtml\Attributes;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Learning\ExtensionAttribute\Api\Data\LearningExtensionAttributeInterfaceFactory;
use Learning\ExtensionAttribute\Model\ResourceModel\LearningExtensionAttribute\CollectionFactory;

class Create extends Action implements HttpPostActionInterface
{
    protected CollectionFactory $collectionFactory;

    protected LearningExtensionAttributeInterfaceFactory $factory;

    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        LearningExtensionAttributeInterfaceFactory $factory
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
        $this->factory = $factory;
    }

    public function execute(): Redirect
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }
        $data = $this->getRequest()->getPostValue();
        try {
            $collection = $this->collectionFactory->create();
            $attribute = $this->factory->create();
            $attribute->setProductId((int) $data['product_id']);
            $attribute->setDescription($data['description']);
            $collection->addItem($attribute);
            $saveData = $collection->save();
            if($saveData){
                $this->messageManager->addSuccessMessage('Success!');
            }
        }catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('learning_extension_attributes/attributes');
    }
}
