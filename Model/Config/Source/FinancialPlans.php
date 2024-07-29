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
use Wibond\Wibond\Model\WibondApi;

class FinancialPlans implements OptionSourceInterface
{
    /**
     * @var WibondApi
     */
    private WibondApi $wibondApi;

    /**
     * @param WibondApi $wibondApi
     */
    public function __construct(
        WibondApi $wibondApi
    ) {
        $this->wibondApi = $wibondApi;
    }

    /**
     * Return options array
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function ($item) {
            return [$item['value'] => $item['label']];
        }, $this->toOptionArray());
    }

    /**
     * Return plan options array
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $items = [];
        $options = $this->wibondApi->getPlanOptions();
        foreach ($options as $option) {
            $items[] = [
                'value' => $option['id'],
                'label' => $option['name'] ?? '(' . $option['code'] . ')',
            ];
        }
        return $items;
    }
}
