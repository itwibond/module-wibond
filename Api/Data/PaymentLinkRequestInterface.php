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
     * @return string
     */
    public function getProductName();

    /**
     * @param string $productName
     * @return self
     */
    public function setProductName(string $productName);

    /**
     * @return float
     */
    public function getAmount();

    /**
     * @param float $amount
     * @return self
     */
    public function setAmount(float $amount);

    /**
     * @return string|null
     */
    public function getUrlSuccess();

    /**
     * @param string|null $successUrl
     * @return self
     */
    public function setUrlSuccess(?string $successUrl);

    /**
     * @return string|null
     */
    public function getCheckoutUrl();

    /**
     * @param string|null $checkoutUrl
     * @return self
     */
    public function setCheckoutUrl(?string $checkoutUrl);

    /**
     * @return string|null
     */
    public function getUrlError();

    /**
     * @param string|null $errorUrl
     * @return self
     */
    public function setUrlError(?string $errorUrl);

    /**
     * @return string|null
     */
    public function getUrlNotification();

    /**
     * @param string|null $notificationUrl
     * @return self
     */
    public function setUrlNotification(?string $notificationUrl);

    /**
     * @return string
     */
    public function getExternalId();

    /**
     * @param string $externalId
     * @return self
     */
    public function setExternalId(string $externalId);

    /**
     * @return PaymentLinkOptionsInterface[]
     */
    public function getOptions();

    /**
     * @param PaymentLinkOptionsInterface[] $options
     * @return self
     */
    public function setOptions(array $options);

    /**
     * @param PaymentLinkOptionsInterface $option
     * @return self
     */
    public function addOption($option);
}
