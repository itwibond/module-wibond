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
     * Get Id
     *
     * @return mixed
     */
    public function getId();

    /**
     * Set Id
     *
     * @param mixed $id
     * @return self
     */
    public function setId($id);

    /**
     * Get Code
     *
     * @return mixed
     */
    public function getCode();

    /**
     * Set Code
     *
     * @param mixed $code
     * @return self
     */
    public function setCode($code);

    /**
     * Get Configurable
     *
     * @return mixed
     */
    public function getConfigurable();

    /**
     * Set Configurable
     *
     * @param mixed $configurable
     * @return self
     */
    public function setConfigurable($configurable);

    /**
     * Get Fees
     *
     * @return mixed
     */
    public function getFees();

    /**
     * Set Fees
     *
     * @param mixed $fees
     * @return self
     */
    public function setFees($fees);

    /**
     * Get Percentage Profit
     *
     * @return mixed
     */
    public function getPercentageProfit();

    /**
     * Set Percentage Profit
     *
     * @param mixed $percentageProfit
     * @return self
     */
    public function setPercentageProfit($percentageProfit);

    /**
     * Get Days frequency Payment
     *
     * @return mixed
     */
    public function getDaysFrequencyPayment();

    /**
     * Set Days Frequency Payment
     *
     * @param mixed $daysFrequencyPayment
     * @return self
     */
    public function setDaysFrequencyPayment($daysFrequencyPayment);

    /**
     * Get External Manage Percentage Profit
     *
     * @return mixed
     */
    public function getExternalManagePercentageProfit();

    /**
     * Set External Manage Percentage Profit
     *
     * @param mixed $externalManagePercentageProfit
     * @return self
     */
    public function setExternalManagePercentageProfit($externalManagePercentageProfit);
}
