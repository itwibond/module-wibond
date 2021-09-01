<?php
/**
 * Wibond_Wibond
 *
 * @copyright  Copyright (c) 2021 Wibond. (https://www.wibond.com.ar/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace Wibond\Wibond\Api\Data;

interface PaymentLinkOptionsInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param mixed $id
     * @return self
     */
    public function setId($id);

    /**
     * @return mixed
     */
    public function getCode();

    /**
     * @param mixed $code
     * @return self
     */
    public function setCode($code);

    /**
     * @return mixed
     */
    public function getConfigurable();

    /**
     * @param mixed $configurable
     * @return self
     */
    public function setConfigurable($configurable);

    /**
     * @return mixed
     */
    public function getFees();

    /**
     * @param mixed $fees
     * @return self
     */
    public function setFees($fees);

    /**
     * @return mixed
     */
    public function getPercentageProfit();

    /**
     * @param mixed $percentageProfit
     * @return self
     */
    public function setPercentageProfit($percentageProfit);

    /**
     * @return mixed
     */
    public function getDaysFrequencyPayment();

    /**
     * @param mixed $daysFrequencyPayment
     * @return self
     */
    public function setDaysFrequencyPayment($daysFrequencyPayment);

    /**
     * @return mixed
     */
    public function getExternalManagePercentageProfit();

    /**
     * @param mixed $externalManagePercentageProfit
     * @return self
     */
    public function setExternalManagePercentageProfit($externalManagePercentageProfit);
}
