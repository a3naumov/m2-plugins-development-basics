<?php

declare(strict_types=1);

namespace Learning\BuildCart\Controller\Index;

use Magento\Checkout\Model\Cart;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\NotFoundException;

class Upload extends Action
{
    protected Cart $cart;

    protected ProductRepository $productRepository;

    public function __construct(
        Context $context,
        Cart $cart,
        ProductRepository $productRepository
    ) {
        $this->cart = $cart;
        $this->productRepository = $productRepository;
        return parent::__construct($context);

    }

    public function execute(): Redirect
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }

        foreach ($_FILES as $file) {
            $handle = fopen($file['tmp_name'], 'r');
            while ($data = fgetcsv($handle, 100, ",")) {
                try {
                    $this->putProductInCart($data);
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                }
            }
            fclose($handle);
        }
        $saveData = $this->cart->save();

        if ($saveData) {
            $this->messageManager->addSuccessMessage('Success!');
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('checkout/cart');
    }

    public function putProductInCart(array $data): void
    {
        $product = $this->productRepository->get($data[0]);
        $this->cart->addProduct($product, ['qty' => (int) $data[1]]);
    }
}
