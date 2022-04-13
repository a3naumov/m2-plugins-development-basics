<?php

declare(strict_types=1);

namespace Learning\CheckoutMessage\Plugin\Checkout;

use Magento\Checkout\Model\Session;
use Magento\Framework\Data\Form\FormKey;
use Magento\Customer\Model\AddressFactory;
use Magento\Framework\View\Element\Template\Context;
use Magento\Checkout\Block\Checkout\LayoutProcessor;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\CheckoutAgreements\Model\ResourceModel\Agreement\CollectionFactory;

class LayoutProcessorPlugin
{
    /**
     * @var ScopeConfigInterface
     */
    protected ScopeConfigInterface $scopeConfig;

    /**
     * @var Session
     */
    protected Session $checkoutSession;

    /**
     * @var AddressFactory
     */
    protected AddressFactory $customerAddressFactory;

    /**
     * @var FormKey
     */
    protected FormKey $formKey;

    public function __construct(
        Context $context,
        CollectionFactory $agreementCollectionFactory,
        Session $checkoutSession,
        AddressFactory $customerAddressFactory
    ) {
        $this->scopeConfig = $context->getScopeConfig();
        $this->checkoutSession = $checkoutSession;
        $this->customerAddressFactory = $customerAddressFactory;
    }
    /**
     * @param LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(LayoutProcessor $subject, array  $jsLayout): array
    {
        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
        ['payment']['children']['payments-list']['children']['before-place-order']['children']['customer_comment'] = [
            'component' => 'Magento_Ui/js/form/element/textarea',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'options' => [],
                'id' => 'customer_comment'
            ],
            'dataScope' => 'ordercomment.customer_comment',
            'label' => 'Order Comment',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'sortOrder' => 250,
            'id' => 'customer_comment'
        ];

        return $jsLayout;
    }
}
