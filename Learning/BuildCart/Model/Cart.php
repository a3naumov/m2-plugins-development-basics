<?php

declare(strict_types=1);

namespace Learning\BuildCart\Model;

use Magento\Framework\File\Csv;
use Magento\Catalog\Model\ProductRepository;
use Magento\Checkout\Model\Cart as CartModel;

class Cart
{
    /**
     * @var \Magento\Checkout\Model\Cart
     */
    private CartModel $cart;

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private ProductRepository $productRepository;

    /**
     * @var \Magento\Framework\File\Csv
     */
    private Csv $csvReader;

    /**
     * @param \Magento\Checkout\Model\Cart $cart
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \Magento\Framework\File\Csv $csvReader
     */
    public function __construct(
        CartModel $cart,
        ProductRepository $productRepository,
        Csv $csvReader
    ) {
        $this->cart = $cart;
        $this->productRepository = $productRepository;
        $this->csvReader = $csvReader;
    }

    /**
     * @param array $file
     * @return array
     * @throws \Exception
     */
    public function readDataFromFile(array $file): array
    {
        return $this->csvReader->getData($file['tmp_name']);
    }

    /**
     * @param array $data
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function putProduct(array $data): void
    {
        foreach ($data as $item) {
            $product = $this->productRepository->get($item[0]);
            $this->cart->addProduct($product, ['qty' => (int) $item[1]]);
        }
        $this->cart->save();
    }
}
