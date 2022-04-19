<?php

declare(strict_types=1);

namespace Learning\CheckoutMessage\Test\Unit\Plugin\Magento\Checkout;

use Learning\CheckoutMessage\Plugin\Magento\Checkout\LayoutProcessor;
use Magento\CheckoutAgreements\Model\ResourceModel\Agreement\CollectionFactory;
use Magento\Checkout\Block\Checkout\LayoutProcessor as CheckoutLayoutProcessor;
use Magento\Checkout\Model\Session;
use Magento\Customer\Model\AddressFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\View\Element\Template\Context;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers LayoutProcessor
 */
class LayoutProcessorTest extends TestCase
{
    /**
     * @var LayoutProcessor
     */
    private LayoutProcessor $object;

    /**
     * @var Context|MockObject
     */
    private Context $context;

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @var CollectionFactory|MockObject
     */
    private CollectionFactory $agreementCollectionFactory;

    /**
     * @var Session|MockObject
     */
    private Session $session;

    /**
     * @var AddressFactory|MockObject
     */
    protected AddressFactory $customerAddressFactory;

    /**
     * @var FormKey
     */
    protected FormKey $formKey;

    /**
     * @var CheckoutLayoutProcessor|MockObject
     */
    protected CheckoutLayoutProcessor $subject;

    protected function setUp(): void
    {
        $this->context = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $scopeConfigMock = $this->getMockBuilder(ScopeConfigInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->agreementCollectionFactory = $this->getMockBuilder(CollectionFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->session = $this->getMockBuilder(Session::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerAddressFactory = $this->getMockBuilder(AddressFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subject = $this->getMockBuilder(CheckoutLayoutProcessor::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->context->expects($this->once())
            ->method('getScopeConfig')
            ->willReturn($scopeConfigMock);

        $this->object = new LayoutProcessor(
            $this->context,
            $this->agreementCollectionFactory,
            $this->session,
            $this->customerAddressFactory
        );
    }

    /**
     * @return void
     */
    public function testAfterProcess(): void
    {
        $this->assertIsArray(
            $this->object->afterProcess(
                $this->subject,
                array()
            )
        );
    }
}
