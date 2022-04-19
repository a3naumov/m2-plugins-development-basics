<?php

declare(strict_types=1);

namespace Learning\BuildCart\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\File\Csv;
use Magento\Catalog\Model\ProductRepository;
use Magento\Checkout\Model\Cart as CartModel;
use Magento\Framework\Message\ManagerInterface;

class Cart
{
    /**
     * @var \Magento\Checkout\Model\Cart
     */
    private CartModel $cart;

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    /**
     * @var Csv
     */
    private Csv $csvReader;

    /**
     * @var ManagerInterface
     */
    private ManagerInterface $messageManager;

    /**
     * @param \Magento\Checkout\Model\Cart $cart
     * @param ProductRepository $productRepository
     * @param Csv $csvReader
     */
    public function __construct(
        CartModel $cart,
        ProductRepository $productRepository,
        Csv $csvReader,
        ManagerInterface $messageManager
    ) {
        $this->cart = $cart;
        $this->productRepository = $productRepository;
        $this->csvReader = $csvReader;
        $this->messageManager = $messageManager;
    }

    /**
     * @param array $file
     * @return array
     */
    public function readDataFromFile(array $file): array
    {
        try {
            return $this->csvReader->getData($file['tmp_name']);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e);
            return array();
        }
    }

    /**
     * @param array $data
     * @return void
     */
    public function putProduct(array $data): void
    {
        if ($data) {
            foreach ($data as $item) {
                try {
                    $product = $this->productRepository->get($item[0]);
                    $this->cart->addProduct($product, ['qty' => (int) $item[1]]);
                } catch (NoSuchEntityException|LocalizedException $e) {
                    $this->messageManager->addErrorMessage($e);
                }
            }
        }

        $this->cart->save();
    }
}
