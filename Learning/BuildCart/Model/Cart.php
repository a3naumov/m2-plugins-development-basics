<?php

declare(strict_types=1);

namespace Learning\BuildCart\Model;

use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\File\Csv;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\QuoteRepository;

class Cart
{
    /**
     * @var QuoteRepository
     */
    private QuoteRepository $quoteRepository;

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    /**
     * @var Csv
     */
    private Csv $csvReader;

    /**
     * @param QuoteRepository $quoteRepository
     * @param ProductRepository $productRepository
     * @param Csv $csvReader
     */
    public function __construct(
        QuoteRepository $quoteRepository,
        ProductRepository $productRepository,
        Csv $csvReader
    ) {
        $this->quoteRepository = $quoteRepository;
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
     * @param Quote $quote
     * @param array $data
     * @return void
     * @throws NoSuchEntityException
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function putProduct(Quote $quote, array $data): void
    {
        if ($data) {
            foreach ($data as $item) {
                $product = $this->productRepository->get($item[0]);
                $quote->addProduct($product)->setQty((float) $item[1]);
            }
            $this->quoteRepository->save($quote);
        }
    }
}
