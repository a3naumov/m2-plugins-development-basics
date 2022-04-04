<?php

declare(strict_types=1);

namespace Learning\BuildCart\Model;

use Magento\Framework\File\Csv;
use Magento\Catalog\Model\ProductRepository;
use Magento\Checkout\Model\Cart as CartModel;

class Cart
{
    private CartModel $cart;

    private ProductRepository $productRepository;

    private Csv $csvReader;

    public function __construct(
        CartModel $cart,
        ProductRepository $productRepository,
        Csv $csvReader
    ) {
        $this->cart = $cart;
        $this->productRepository = $productRepository;
        $this->csvReader = $csvReader;
    }

    public function readDataFromFile(array $file): array
    {
        return $this->csvReader->getData($file['tmp_name']);
    }

    public function putProduct(array $data): void
    {
        foreach ($data as $item) {
            $product = $this->productRepository->get($item[0]);
            $this->cart->addProduct($product, ['qty' => (int) $item[1]]);
        }
        $this->cart->save();
    }
}
