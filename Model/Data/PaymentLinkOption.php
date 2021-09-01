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
use Wibond\Wibond\Api\Data\PaymentLinkOptions;
use Wibond\Wibond\Api\Data\PaymentLinkOptionsInterface;

class PaymentLinkOption extends DataObject implements PaymentLinkOptionsInterface
{
    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getData('id');
    }

    /**
     * @inheritDoc
     */
    public function setId($id)
    {
        $this->setData('id', $id);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCode()
    {
        return $this->getData('code');
    }

    /**
     * @inheritDoc
     */
    public function setCode($code)
    {
        $this->setData('code', $code);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getConfigurable()
    {
        return $this->getData('configurable');
    }

    /**
     * @inheritDoc
     */
    public function setConfigurable($configurable)
    {
        $this->setData('configurable', $configurable);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getFees()
    {
        return $this->getData('fees');
    }

    /**
     * @inheritDoc
     */
    public function setFees($fees)
    {
        $this->setData('fees', $fees);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPercentageProfit()
    {
        return $this->getData('percentageProfit');
    }

    /**
     * @inheritDoc
     */
    public function setPercentageProfit($percentageProfit)
    {
        $this->setData('percentageProfit', $percentageProfit);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDaysFrequencyPayment()
    {
        return $this->getData('daysFrequencyPayment');
    }

    /**
     * @inheritDoc
     */
    public function setDaysFrequencyPayment($daysFrequencyPayment)
    {
        $this->setData('daysFrequencyPayment', $daysFrequencyPayment);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getExternalManagePercentageProfit()
    {
        return $this->getData('externalManagePercentageProfit');
    }

    /**
     * @inheritDoc
     */
    public function setExternalManagePercentageProfit($externalManagePercentageProfit)
    {
        $this->setData('externalManagePercentageProfit', $externalManagePercentageProfit);
        return $this;
    }
}
