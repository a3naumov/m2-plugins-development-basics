<?php

declare(strict_types=1);

namespace Learning\BuildCart\Controller\Index;

use Learning\BuildCart\Model\Cart;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;

class Upload implements ActionInterface
{
    /**
     * @var Http
     */
    private Http $request;

    /**
     * @var Session
     */
    private Session $session;

    /**
     * @var MessageManagerInterface
     */
    private MessageManagerInterface $messageManager;

    /**
     * @var ResultFactory
     */
    private ResultFactory $resultFactory;

    /**
     * @var RedirectInterface
     */
    private RedirectInterface $redirect;

    /**
     * @var Cart
     */
    private Cart $cart;

    /**
     * @param Http $request
     * @param Session $session
     * @param MessageManagerInterface $messageManager
     * @param ResultFactory $resultFactory
     * @param RedirectInterface $redirect
     * @param Cart $cart
     */
    public function __construct(
        HTTP $request,
        Session $session,
        MessageManagerInterface $messageManager,
        ResultFactory $resultFactory,
        RedirectInterface $redirect,
        Cart $cart
    ) {
        $this->request = $request;
        $this->session = $session;
        $this->messageManager = $messageManager;
        $this->resultFactory = $resultFactory;
        $this->redirect = $redirect;
        $this->cart = $cart;
    }

    /**
     * @return Redirect
     * @throws NotFoundException
     */
    public function execute(): Redirect
    {
        if (!$this->request->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }

        try {
            $quote = $this->session->getQuote();
            foreach ($_FILES as $file) {
                $data = $this->cart->readDataFromFile($file);
                $this->cart->putProduct($quote, $data);
            }
        } catch (\Exception | NoSuchEntityException | LocalizedException $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setUrl($this->redirect->getRefererUrl());
        }

        $this->messageManager->addSuccessMessage(__('Success!'));
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('checkout/cart');
    }
}
