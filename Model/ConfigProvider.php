<?php
/**
 * Wibond_Wibond
 *
 * @copyright  Copyright (c) 2021 Wibond. (https://www.wibond.com.ar/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace Wibond\Wibond\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\UrlInterface;
use Wibond\Wibond\Config\Config;

class ConfigProvider implements ConfigProviderInterface
{
    /**
     * @var UrlInterface
     */
    private UrlInterface $urlBuilder;

    /**
     * @var Config
     */
    private Config $config;

    /**
     * @param UrlInterface $urlBuilder
     * @param Config $config
     */
    public function __construct(
        UrlInterface $urlBuilder,
        Config       $config
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->config = $config;
    }

    /**
     * @return \array[][]
     */
    public function getConfig(): array
    {
        return [
            'payment' => [
                'wibond' => [
                    'redirectUrl' => $this->urlBuilder->getUrl('wibond/start'),
                    'instructions' => $this->config->getValue('instructions')
                ]
            ]
        ];
    }
}
