<?php

declare(strict_types=1);

namespace Learning\BuildCart\Controller\Index;

use Learning\BuildCart\Model\Cart;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\NotFoundException;

class Upload extends Action
{
    private Cart $cart;

    public function __construct(
        Context $context,
        Cart $cart
    ) {
        $this->cart = $cart;
        return parent::__construct($context);
    }

    public function execute(): Redirect
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }

        foreach ($_FILES as $file) {
            $data = $this->cart->readDataFromFile($file);
            $this->cart->putProduct($data);
        }

        $this->messageManager->addSuccessMessage('Success!');
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('checkout/cart');
    }
}
