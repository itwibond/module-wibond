<?php
/**
 * Wibond_Wibond
 *
 * @copyright  Copyright (c) 2021 Wibond. (https://www.wibond.com.ar/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace Wibond\Wibond\Model\Payment;

use Magento\Payment\Model\Method\Adapter;

class Wibond extends Adapter
{
    public const CODE = 'wibond';
    public const WIBOND_STATUS_IN_PROGRESS = 'IN_PROGRESS';
    public const WIBOND_STATUS_COMPLETED = 'COMPLETED';
    public const WIBOND_STATUS_PENDING = 'PENDING';

    /**
     * @inheritdoc
     */
    public function canUseInternal()
    {
        return (bool) false;
    }

    /**
     * @inheritdoc
     */
    public function canUseCheckout()
    {
        return (bool) true;
    }

    /**
     * @inheritdoc
     */
    public function isGateway()
    {
        return (bool) true;
    }

    /**
     * @inheritdoc
     */
    public function initialize($paymentAction, $stateObject)
    {
        return $this->adapter->initialize($paymentAction, $stateObject);
    }
}
