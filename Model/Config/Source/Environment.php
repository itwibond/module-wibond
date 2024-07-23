<?php
/**
 * Wibond_Wibond
 *
 * @copyright  Copyright (c) 2021 Wibond. (https://www.wibond.com.ar/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace Wibond\Wibond\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Environment implements OptionSourceInterface
{
    public const ENV_TESTING = 'testing';
    public const ENV_PRODUCTION = 'production';

    /**
     * Return option arrau
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function ($item) {
            return [$item['value'] => $item['label']];
        }, $this->toOptionArray());
    }

    /**
     * Return option array
     *
     * @return array[]
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => static::ENV_TESTING,
                'label' => __('Testing')
            ],
            [
                'value' => static::ENV_PRODUCTION,
                'label' => __('Production')
            ]
        ];
    }
}
