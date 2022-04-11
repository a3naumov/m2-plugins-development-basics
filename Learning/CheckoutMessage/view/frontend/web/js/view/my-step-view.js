define([
    'ko',
    'uiComponent',
    'underscore',
    'Magento_Checkout/js/model/step-navigator'
], function (ko, Component, _, stepNavigator) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Learning_CheckoutMessage/customer_message_step'
        },

        isVisible: ko.observable(true),

        /**
         * @returns {*}
         */
        initialize: function () {
            this._super();

            stepNavigator.registerStep(
                'customer_message_step',
                null,
                'Message to order',
                this.isVisible,
                _.bind(this.navigate, this),
                15
            );

            return this;
        },

        navigate: function () {
            this.isVisible(true);
        },

        /**
         * @returns void
         */
        navigateToNextStep: function () {
            stepNavigator.next();
        }
    });
});
