<?php

declare(strict_types=1);

namespace Learning\CheckoutMessage\Plugin\Magento\Checkout;

use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Checkout\Model\PaymentInformationManagement;

class PaymentInformationManagementPlugin
{
    /**
     * @var OrderRepositoryInterface
     */
    protected OrderRepositoryInterface $orderRepository;

    /**
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
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
            $orderComment =$paymentMethod->getExtensionAttributes();
            if ($orderComment->getComment())
                $comment = trim($orderComment->getComment());
            else
                $comment = '';
            $history = $order->addStatusHistoryComment($comment);
            $history->save();
            $order->setCustomerNote($comment);
        }

        return $result;
    }
}
