<?php
/**
 * Wibond_Wibond
 *
 * @copyright  Copyright (c) 2021 Wibond. (https://www.wibond.com.ar/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace Wibond\Wibond\Model\Data;

use Magento\Framework\DataObject;
use Wibond\Wibond\Api\Data\PaymentLinkRequestInterface;

class PaymentLinkRequest extends DataObject implements PaymentLinkRequestInterface
{
    /**
     * @inheritDoc
     */
    public function getProductName()
    {
        return $this->getData('productName');
    }

    /**
     * @inheritDoc
     */
    public function setProductName(string $productName)
    {
        $this->setData('productName', $productName);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAmount()
    {
        return $this->getData('amount');
    }

    /**
     * @inheritDoc
     */
    public function setAmount(float $amount)
    {
        $this->setData('amount', $amount);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUrlSuccess()
    {
        return $this->getData('urlSuccess');
    }

    /**
     * @inheritDoc
     */
    public function setUrlSuccess(?string $successUrl)
    {
        $this->setData('urlSuccess', $successUrl);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCheckoutUrl()
    {
        return $this->getData('checkoutUrl');
    }

    /**
     * @inheritDoc
     */
    public function setCheckoutUrl(?string $checkoutUrl)
    {
        $this->setData('checkoutUrl', $checkoutUrl);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUrlError()
    {
        return $this->getData('urlError');
    }

    /**
     * @inheritDoc
     */
    public function setUrlError(?string $errorUrl)
    {
        $this->setData('urlError', $errorUrl);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUrlNotification()
    {
        return $this->getData('urlNotification');
    }

    /**
     * @inheritDoc
     */
    public function setUrlNotification(?string $notificationUrl)
    {
        $this->setData('urlNotification', $notificationUrl);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getExternalId()
    {
        return $this->getData('externalId');
    }

    /**
     * @inheritDoc
     */
    public function setExternalId(string $externalId)
    {
        $this->setData('externalId', $externalId);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addOption($option)
    {
        $options = $this->getOptions();
        if ($options === null) {
            $options = [];
        }
        $options[] = $option;
        $this->setOptions($options);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getOptions()
    {
        return $this->getData('options');
    }

    /**
     * @inheritDoc
     */
    public function setOptions(array $options)
    {
        $this->setData('options', $options);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(array $keys = []): array
    {
        $array = parent::toArray($keys);
        if (isset($array['options'])) {
            $options = [];
            foreach ($array['options'] as $option) {
                $options[] = $option->toArray();
            }
            $array['options'] = $options;
        }
        return $array;
    }
}
