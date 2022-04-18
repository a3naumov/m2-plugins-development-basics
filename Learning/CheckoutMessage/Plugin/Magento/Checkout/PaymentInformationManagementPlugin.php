<?php

declare(strict_types=1);

namespace Learning\CheckoutMessage\Plugin\Magento\Checkout;

use Magento\Checkout\Model\PaymentInformationManagement;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\ResourceModel\Order;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Quote\Api\Data\PaymentExtensionInterface;

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
     * @param OrderRepositoryInterface $orderRepository
     * @param Order $orderResource
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        Order $orderResource
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderResource = $orderResource;
    }

    /**
     * @param PaymentInformationManagement $subject
     * @param string $result
     * @param int $cartId
     * @param PaymentInterface $paymentMethod
     * @param AddressInterface|null $billingAddress
     * @return string
     * @throws \Exception
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
            $orderComment = $this->getComment(null);

            $order->addCommentToStatusHistory($orderComment);
            $order->setCustomerNote($orderComment);
            $this->orderResource->save($order);
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
