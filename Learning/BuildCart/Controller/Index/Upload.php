<?php

declare(strict_types=1);

namespace Learning\BuildCart\Controller\Index;

use Learning\BuildCart\Model\Cart;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;

class Upload extends Action
{
    /**
     * @var \Learning\BuildCart\Model\Cart
     */
    private Cart $cart;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Learning\BuildCart\Model\Cart $cart
     */
    public function __construct(
        Context $context,
        Cart $cart
    ) {
        $this->cart = $cart;
        return parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute(): Redirect
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }

        foreach ($_FILES as $file) {
            try {
                $data = $this->cart->readDataFromFile($file);
                $this->cart->putProduct($data);
            } catch (\Exception | NoSuchEntityException | LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setUrl($this->_redirect->getRefererUrl());
            }
        }

        $this->messageManager->addSuccessMessage('Success!');
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('checkout/cart');
    }
}
