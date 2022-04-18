<?php

declare(strict_types=1);

namespace Learning\CheckoutMessage\Plugin\Magento\Checkout;

use Magento\Checkout\Model\PaymentInformationManagement;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\ResourceModel\Order;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Quote\Api\Data\PaymentExtensionInterface;
use Magento\Framework\Message\ManagerInterface;

class PaymentInformationManagementPlugin
{
    /**
     * @var OrderRepositoryInterface
     */
    protected OrderRepositoryInterface $orderRepository;

    /**
     * @var Order
     */
    protected Order $orderResource;

    /**
     * @var ManagerInterface
     */
    protected ManagerInterface $messageManager;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param Order $orderResource
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        Order $orderResource,
        ManagerInterface $messageManager
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderResource = $orderResource;
        $this->messageManager = $messageManager;
    }

    /**
     * @param PaymentInformationManagement $subject
     * @param string $result
     * @param int $cartId
     * @param PaymentInterface $paymentMethod
     * @param AddressInterface|null $billingAddress
     * @return string
     */
    public function afterSavePaymentInformationAndPlaceOrder(
        PaymentInformationManagement $subject,
        string $result,
        int $cartId,
        PaymentInterface $paymentMethod,
        AddressInterface $billingAddress = null
    ): string
    {
        if($result){
            $order = $this->orderRepository->get($result);
            $orderComment = $this->getComment($paymentMethod->getExtensionAttributes());

            $order->addCommentToStatusHistory($orderComment);
            $order->setCustomerNote($orderComment);

            try {
                $this->orderResource->save($order);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e);
            }
        }

        return $result;
    }

    /**
     * @param PaymentExtensionInterface|null $extensionAttributes
     * @return string
     */
    public function getComment(?PaymentExtensionInterface $extensionAttributes): string
    {
        return ($extensionAttributes && $extensionAttributes->getComment())
            ? trim($extensionAttributes->getComment())
            : '';
    }
}
