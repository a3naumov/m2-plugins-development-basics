<?php

declare(strict_types=1);

namespace Learning\CheckoutMessage\Test\Unit\Plugin\Magento\Checkout;

use Learning\CheckoutMessage\Plugin\Magento\Checkout\PaymentInformationManagementPlugin;
use Magento\Checkout\Model\PaymentInformationManagement;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\ResourceModel\Order;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Quote\Api\Data\PaymentExtensionInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers PaymentInformationManagementPlugin
 */
class PaymentInformationManagementPluginTest extends TestCase
{
    /**
     * @var PaymentInformationManagementPlugin
     */
    private PaymentInformationManagementPlugin $object;

    /**
     * @var OrderRepositoryInterface|MockObject
     */
    private OrderRepositoryInterface $orderRepository;

    /**
     * @var Order|MockObject
     */
    private Order $orderResource;

    /**
     * @var PaymentInformationManagement|MockObject
     */
    private PaymentInformationManagement $subject;

    /**
     * @var PaymentInterface|MockObject
     */
    private PaymentInterface $paymentMethod;

    /**
     * @var PaymentExtensionInterface|MockObject
     */
    private PaymentExtensionInterface $extensionAttributes;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->orderRepository = $this->getMockBuilder(OrderRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderResource = $this->getMockBuilder(Order::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subject = $this->getMockBuilder(PaymentInformationManagement::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->paymentMethod = $this->getMockBuilder(PaymentInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->extensionAttributes = $this->getMockBuilder(PaymentExtensionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new PaymentInformationManagementPlugin(
            $this->orderRepository,
            $this->orderResource
        );
    }

    /**
     * @dataProvider getCommentProvider
     *
     * @param string $actual
     * @param string $expected
     * @return void
     */
    public function testGetComment(string $actual, string $expected): void
    {
        $this->extensionAttributes->expects($this->any())
            ->method('getComment')
            ->willReturn($actual);

        $this->assertEquals($expected, $this->object->getComment($this->extensionAttributes));
    }

    /**
     * @return \string[][]
     */
    public function getCommentProvider(): array
    {
        return [
            ['', ''],
            ['Comment', 'Comment'],
            ['   Comment ', 'Comment']
        ];
    }
}
