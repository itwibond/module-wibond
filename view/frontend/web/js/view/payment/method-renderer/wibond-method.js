/**
 * Wibond_Wibond
 *
 * @copyright  Copyright (c) 2021 Wibond. (https://www.wibond.com.ar/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
define([
    'jquery',
    'Magento_Checkout/js/view/payment/default',
    'Magento_Customer/js/customer-data',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/action/set-payment-information'
], function ($, Component, customerData, quote, setPaymentInformation) {
    'use strict';

    return Component.extend({
        redirectAfterPlaceOrder: false,

        defaults: {
            template: 'Wibond_Wibond/payment/wibond'
        },

        getInstructions: function () {
            return window.checkoutConfig.payment.wibond.instructions;
        },

        afterPlaceOrder: function () {
            window.location.replace(window.checkoutConfig.payment.wibond.redirectUrl);
        }
    });
});
