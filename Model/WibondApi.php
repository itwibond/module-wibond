<?php
/**
 * Wibond_Wibond
 *
 * @copyright  Copyright (c) 2021 Wibond. (https://www.wibond.com.ar/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace Wibond\Wibond\Model;

use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\HTTP\Client\CurlFactory;
use Magento\Framework\Serialize\Serializer\Json as Serializer;
use Wibond\Wibond\Api\Data\PaymentLinkRequestInterface;
use Wibond\Wibond\Config\Config;

class WibondApi
{
    const FINANCIAL_OPTIONS_KEY = 'plans';
    const FINANCIAL_FREQUENCY_KEY = 'frequencyOptions';
    const FINANCIAL_FEE_KEY = 'fees';

    /**
     * @var CurlFactory
     */
    private CurlFactory $curlFactory;

    /**
     * @var Config
     */
    private Config $config;

    /**
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * @param CurlFactory $curlFactory
     * @param Config $config
     * @param Serializer $serializer
     */
    public function __construct(
        CurlFactory $curlFactory,
        Config $config,
        Serializer $serializer
    ) {
        $this->curlFactory = $curlFactory;
        $this->config = $config;
        $this->serializer = $serializer;
    }

    /**
     * @return array
     */
    public function getPlanOptions(): array
    {
        $planOptions = $this->getFinancialPlanOptions();
        return $planOptions[static::FINANCIAL_OPTIONS_KEY] ?? [];
    }

    /**
     * @return array|bool|float|int|mixed|string|null
     */
    public function getFinancialPlanOptions()
    {
        $curlClient = $this->getCurlClient();
        $curlClient->get($this->config->getFinancialOptionsUrl());
        return $this->serializer->unserialize($curlClient->getBody());
    }

    /**
     * @return Curl
     */
    protected function getCurlClient(): Curl
    {
        $curlClient = $this->curlFactory->create();
        $authKey = $this->config->getAuthSecret();
        $curlClient->addHeader('Authorization', $authKey);
        return $curlClient;
    }

    /**
     * @return array|mixed|string
     */
    public function getFrequencyOptions()
    {
        $planOptions = $this->getFinancialPlanOptions();
        return $planOptions[static::FINANCIAL_FREQUENCY_KEY] ?? [];
    }

    /**
     * @return array|mixed|string
     */
    public function getFeeOptions()
    {
        $planOptions = $this->getFinancialPlanOptions();
        return $planOptions[static::FINANCIAL_FEE_KEY] ?? [];
    }

    /**
     * @param PaymentLinkRequestInterface $paymentLinkRequest
     * @return array|bool|float|int|mixed|string|null
     */
    public function getPayUrl(PaymentLinkRequestInterface $paymentLinkRequest)
    {
        $curlClient = $this->getCurlClient();
        $curlClient->addHeader('Content-Type', 'application/json');
        $curlClient->post($this->config->getLinkPaymentUrl(), $this->serializer
            ->serialize($paymentLinkRequest->toArray()));
        return $this->serializer->unserialize($curlClient->getBody());
    }
}
