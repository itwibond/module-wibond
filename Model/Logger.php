<?php
/**
 * Wibond_Wibond
 *
 * @copyright  Copyright (c) 2021 Wibond. (https://www.wibond.com.ar/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace Wibond\Wibond\Model;

use Psr\Log\LoggerInterface;
use Wibond\Wibond\Config\Config;

class Logger
{

    /**
     * @var Config
     */
    private Config $config;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $loggerInterface;

    /**
     * @param Config $config
     * @param LoggerInterface $loggerInterface
     */
    public function __construct(
        Config $config,
        LoggerInterface $loggerInterface
    ) {
        $this->config = $config;
        $this->loggerInterface = $loggerInterface;
    }

    /**
     * Log
     *
     * @param string|array $message
     * @param array $context
     */
    public function log($message, array $context = [])
    {
        if ($this->config->getDebug()) {
            $this->loggerInterface->info($message, $context);
        }
    }
}
