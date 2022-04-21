<?php

declare(strict_types=1);

namespace Learning\BuildCart\Test\Unit\Controller\Index;

use Learning\BuildCart\Controller\Index\Upload;
use Learning\BuildCart\Model\Cart;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UploadTest extends TestCase
{
    /**
     * @var Upload
     */
    private Upload $object;

    /**
     * @var Http|MockObject
     */
    private Http $request;

    /**
     * @var Session|MockObject
     */
    private Session $session;

    /**
     * @var MessageManagerInterface|MockObject
     */
    private MessageManagerInterface $messageManager;

    /**
     * @var ResultFactory|MockObject
     */
    private ResultFactory $resultFactory;

    /**
     * @var RedirectInterface|MockObject
     */
    private RedirectInterface $redirect;

    /**
     * @var Cart|MockObject
     */
    private Cart $cart;

    /**
     * @var Redirect|MockObject
     */
    private Redirect $redirectResult;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->request = $this->getMockBuilder(Http::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->session = $this->getMockBuilder(Session::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->messageManager = $this->getMockBuilder(MessageManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultFactory = $this->getMockBuilder(ResultFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->redirect = $this->getMockBuilder(RedirectInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cart = $this->getMockBuilder(Cart::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->redirectResult = $this->getMockBuilder(Redirect::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->object = new Upload(
            $this->request,
            $this->session,
            $this->messageManager,
            $this->resultFactory,
            $this->redirect,
            $this->cart
        );
    }

    /**
     * @return void
     * @throws NotFoundException
     */
    public function testExecute(): void
    {
        $this->request->expects($this->once())
            ->method('isPost')
            ->willReturn(true);

        $this->resultFactory->expects($this->once())
            ->method('create')
            ->with(ResultFactory::TYPE_REDIRECT)
            ->willReturn($this->redirectResult);

        $this->redirectResult->expects($this->once())
            ->method('setPath')
            ->with('checkout/cart')
            ->willReturn($this->redirectResult);

        $this->object->execute();
    }

    /**
     * @return void
     * @throws NotFoundException
     */
    public function testExecuteWithException(): void
    {
        $_FILES = [
          'file' => [
              'tmp_name' => '/path/'
          ]
        ];

        $this->request->expects($this->once())
            ->method('isPost')
            ->willReturn(true);

        $this->cart->expects($this->once())
            ->method('readDataFromFile')
            ->willThrowException(new \Exception('Exception'));

        $this->resultFactory->expects($this->once())
            ->method('create')
            ->with(ResultFactory::TYPE_REDIRECT)
            ->willReturn($this->redirectResult);

        $this->redirectResult->expects($this->once())
            ->method('setUrl')
            ->willReturn($this->redirectResult);

        $this->object->execute();
    }

    /**
     * @return void
     * @throws NotFoundException
     */
    public function testExecuteWithNoSuchEntityException(): void
    {
        $_FILES = [
            'file' => [
                'tmp_name' => '/path/'
            ]
        ];

        $this->request->expects($this->once())
            ->method('isPost')
            ->willReturn(true);

        $this->cart->expects($this->once())
            ->method('readDataFromFile')
            ->willThrowException(new NoSuchEntityException(__('Exception')));

        $this->resultFactory->expects($this->once())
            ->method('create')
            ->with(ResultFactory::TYPE_REDIRECT)
            ->willReturn($this->redirectResult);

        $this->redirectResult->expects($this->once())
            ->method('setUrl')
            ->willReturn($this->redirectResult);

        $this->object->execute();
    }

    /**
     * @return void
     * @throws NotFoundException
     */
    public function testExecuteWithLocalizedException(): void
    {
        $_FILES = [
            'file' => [
                'tmp_name' => '/path/'
            ]
        ];

        $this->request->expects($this->once())
            ->method('isPost')
            ->willReturn(true);

        $this->cart->expects($this->once())
            ->method('readDataFromFile')
            ->willThrowException(new LocalizedException(__('Exception')));

        $this->resultFactory->expects($this->once())
            ->method('create')
            ->with(ResultFactory::TYPE_REDIRECT)
            ->willReturn($this->redirectResult);

        $this->redirectResult->expects($this->once())
            ->method('setUrl')
            ->willReturn($this->redirectResult);

        $this->object->execute();
    }
}
