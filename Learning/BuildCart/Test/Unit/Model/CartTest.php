<?php

declare(strict_types=1);

namespace Learning\BuildCart\Test\Unit\Model;

use Learning\BuildCart\Model\Cart;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\File\Csv;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Item;
use Magento\Quote\Model\QuoteRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    /**
     * @var Cart
     */
    private Cart $object;

    /**
     * @var QuoteRepository|MockObject
     */
    private QuoteRepository $quoteRepository;

    /**
     * @var ProductRepository|MockObject
     */
    private ProductRepository $productRepository;

    /**
     * @var Csv|MockObject
     */
    private Csv $csvReader;

    /**
     * @var Quote|MockObject
     */
    private Quote $quote;

    /**
     * @var Product|MockObject
     */
    private Product $product;

    /**
     * @var Item|MockObject
     */
    private Item $item;

    protected function setUp(): void
    {
        $this->quoteRepository = $this->getMockBuilder(QuoteRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productRepository = $this->getMockBuilder(ProductRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->csvReader = $this->getMockBuilder(Csv::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quote = $this->getMockBuilder(Quote::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->product = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->item = $this->getMockBuilder(Item::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new Cart(
            $this->quoteRepository,
            $this->productRepository,
            $this->csvReader
        );
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testReadDataFromFile(): void
    {
        $file = ['tmp_name' => '/path/'];

        $this->csvReader->expects($this->once())
            ->method('getData')
            ->willReturn(array());

        $this->object->readDataFromFile($file);
    }

    /**
     * @return void
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function testPutProduct(): void
    {
        $data = [
            ['MH05-L-Green', '1']
        ];

        $this->productRepository->expects($this->once())
            ->method('get')
            ->willReturn($this->product);

        $this->quote->expects($this->once())
            ->method('addProduct')
            ->with($this->product)
            ->willReturn($this->item);

        $this->object->putProduct($this->quote, $data);
    }
}
