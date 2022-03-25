<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Controller\Adminhtml\Attributes;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Learning\ExtensionAttribute\Api\ExtensionAttributeRepositoryInterface;
use Learning\ExtensionAttribute\Model\ResourceModel\LearningExtensionAttribute\CollectionFactory;

class MassDelete extends Action implements HttpPostActionInterface
{
    protected Filter $filter;

    protected CollectionFactory $collectionFactory;

    protected ExtensionAttributeRepositoryInterface $repository;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ExtensionAttributeRepositoryInterface $repository
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->repository = $repository;
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $categoryDeleted = 0;
        foreach ($collection->getItems() as $attribute) {
            $this->repository->delete($attribute);
            $categoryDeleted++;
        }
        if ($categoryDeleted) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 attribute(s) have been deleted.', $categoryDeleted)
            );
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('learning_extension_attributes/attributes');
    }
}
