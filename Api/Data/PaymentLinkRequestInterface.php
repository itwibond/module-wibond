<?php
/**
 * Wibond_Wibond
 *
 * @copyright  Copyright (c) 2021 Wibond. (https://www.wibond.com.ar/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace Wibond\Wibond\Api\Data;

interface PaymentLinkRequestInterface
{
    /**
     * Get Product Name
     *
     * @return string
     */
    public function getProductName();

    /**
     * Set Product Name
     *
     * @param string $productName
     * @return self
     */
    public function setProductName(string $productName);

    /**
     * Get Amount
     *
     * @return float
     */
    public function getAmount();

    /**
     * Set Amount
     *
     * @param float $amount
     * @return self
     */
    public function setAmount(float $amount);

    /**
     * Get Url Success
     *
     * @return string|null
     */
    public function getUrlSuccess();

    /**
     * Set Url Success
     *
     * @param string|null $successUrl
     * @return self
     */
    public function setUrlSuccess(?string $successUrl);

    /**
     * Get Checkout Url
     *
     * @return string|null
     */
    public function getCheckoutUrl();

    /**
     * Set Checkout Url
     *
     * @param string|null $checkoutUrl
     * @return self
     */
    public function setCheckoutUrl(?string $checkoutUrl);

    /**
     * Get Url Error
     *
     * @return string|null
     */
    public function getUrlError();

    /**
     * Set Url Error
     *
     * @param string|null $errorUrl
     * @return self
     */
    public function setUrlError(?string $errorUrl);

    /**
     * Get Url Notification
     *
     * @return string|null
     */
    public function getUrlNotification();

    /**
     * Set Url Notification
     *
     * @param string|null $notificationUrl
     * @return self
     */
    public function setUrlNotification(?string $notificationUrl);

    /**
     * Get External Id
     *
     * @return string
     */
    public function getExternalId();

    /**
     * Set External ID
     *
     * @param string $externalId
     * @return self
     */
    public function setExternalId(string $externalId);

    /**
     * Get Options
     *
     * @return PaymentLinkOptionsInterface[]
     */
    public function getOptions();

    /**
     * Set Options
     *
     * @param PaymentLinkOptionsInterface[] $options
     * @return self
     */
    public function setOptions(array $options);

    /**
     * Add Option
     *
     * @param PaymentLinkOptionsInterface $option
     * @return self
     */
    public function addOption($option);
}
