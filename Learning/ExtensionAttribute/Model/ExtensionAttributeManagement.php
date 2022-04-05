<?php

declare(strict_types=1);

namespace Learning\ExtensionAttribute\Model;

use Magento\Framework\Webapi\Rest\Request;
use Learning\ExtensionAttribute\Api\ExtensionAttributeManagementInterface;
use Learning\ExtensionAttribute\Api\Data\LearningExtensionAttributeInterfaceFactory;
use Learning\ExtensionAttribute\Model\ResourceModel\LearningExtensionAttribute\CollectionFactory;

class ExtensionAttributeManagement implements ExtensionAttributeManagementInterface
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var LearningExtensionAttributeInterfaceFactory
     */
    private LearningExtensionAttributeInterfaceFactory $factory;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collection;

    /**
     * @var ExtensionAttributeRepository
     */
    private ExtensionAttributeRepository $repository;

    /**
     * @param Request $request
     * @param LearningExtensionAttributeInterfaceFactory $factory
     * @param CollectionFactory $collection
     * @param ExtensionAttributeRepository $repository
     */
    public function __construct(
        Request $request,
        LearningExtensionAttributeInterfaceFactory $factory,
        CollectionFactory $collection,
        ExtensionAttributeRepository $repository
    ) {
        $this->request = $request;
        $this->factory = $factory;
        $this->collection = $collection;
        $this->repository = $repository;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function createAttributes(): string
    {
        $count = 0;
        $params = $this->request->getBodyParams();
        $collection = $this->collection->create();
        foreach ($params as $param) {
            $attribute = $this->factory->create();
            $attribute->setProductId($param['product_id']);
            $attribute->setDescription($param['description']);
            $collection->addItem($attribute);
            $count++;
            if ($count === 500) {
                $count = 0;
                $collection->save();
                $collection->clear();
            }
        }
        $collection->save();
        return 'Success!';
    }

    /**
     * @return string
     */
    public function deleteAttributes(): string
    {
        $params = $this->request->getBodyParams();
        foreach ($params as $param) {
            $this->repository->deleteByProductId($param['product_id']);
        }
        return 'Success!';
    }
}
