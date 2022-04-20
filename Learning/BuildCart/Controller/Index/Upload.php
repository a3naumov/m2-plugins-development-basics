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
use Magento\Checkout\Model\Session;

class Upload extends Action
{
    /**
     * @var Session
     */
    private Session $session;

    /**
     * @var Cart
     */
    private Cart $cart;

    /**
     * @param Session $session
     * @param Context $context
     * @param Cart $cart
     */
    public function __construct(
        Session $session,
        Context $context,
        Cart $cart
    ) {
        $this->session = $session;
        $this->cart = $cart;
        return parent::__construct($context);
    }

    /**
     * @return Redirect
     * @throws NotFoundException
     */
    public function execute(): Redirect
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }

        try {
            $quote = $this->session->getQuote();
            foreach ($_FILES as $file) {
                $data = $this->cart->readDataFromFile($file);
                $this->cart->putProduct($quote, $data);
            }
        } catch (\Exception | NoSuchEntityException | LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setUrl($this->_redirect->getRefererUrl());
        }


        $this->messageManager->addSuccessMessage('Success!');
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('checkout/cart');
    }
}
