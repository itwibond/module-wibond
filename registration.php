<?php
/**
 * Wibond_Wibond
 *
 * @copyright  Copyright (c) 2021 Wibond. (https://www.wibond.com.ar/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Wibond_Wibond',
    __DIR__
);
