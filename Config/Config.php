<?php
/**
 * Wibond_Wibond
 *
 * @copyright  Copyright (c) 2021 Wibond. (https://www.wibond.com.ar/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace Wibond\Wibond\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Payment\Gateway\Config\Config as MagentoConfig;
use Wibond\Wibond\Model\Config\Source\Environment;
use Wibond\Wibond\Model\Payment\Wibond;

class Config extends MagentoConfig
{
    const KEY_WIBOND_LINK_ID = 'wibond_link_id';

    /**
     * @var EncryptorInterface
     */
    private EncryptorInterface $encryptor;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param EncryptorInterface $encryptor
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        EncryptorInterface   $encryptor
    ) {
        parent::__construct($scopeConfig, Wibond::CODE);
        $this->encryptor = $encryptor;
    }

    /**
     * @return string
     */
    public function getFinancialOptionsUrl(): string
    {
        return $this->getBaseUrl() . '/payment-link/financial-plan-options';
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->getEnvironment() === Environment::ENV_PRODUCTION ?
            'https://api.wibond.com.ar/api/v1' :
            'https://api-preprod.wibond.com.ar/api/v1';
    }

    /**
     * @return string
     */
    public function getDebug(): string
    {
        return $this->getValue('debug');
    }

    /**
     * @return mixed|null
     */
    public function getEnvironment()
    {
        return $this->getValue('environment');
    }

    /**
     * @return string
     */
    public function getLinkPaymentUrl(): string
    {
        $tenantId = $this->getValue('tenant_id');
        $walletId = $this->getValue('wallet_id');
        return $this->getBaseUrl() . "/payment-link/anonymous/create-payment-link/${tenantId}/wallet/${walletId}";
    }

    /**
     * @return array
     */
    public function getPaymentOptions(): array
    {
        return explode(',', $this->getValue('financial_plan'));
    }

    /**
     * @return string
     */
    public function getAuthSecret(): string
    {
        return $this->encryptor->decrypt($this->getValue('auth_secret'));
    }

    /**
     * @return string
     */
    public function getStatusRejected(): string
    {
        return $this->getValue('status_rejected');
    }

    /**
     * @return string
     */
    public function getStatusPay(): string
    {
        return $this->getValue('status_pay');
    }
}
