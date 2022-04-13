var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/place-order': {
                'Learning_CheckoutMessage/js/order/place-order-mixin': true
            },
            'Magento_Checkout/js/action/set-payment-information': {
                'Learning_CheckoutMessage/js/order/set-payment-information-mixin': true
            }
        }
    }
};
