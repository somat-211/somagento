<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Magefan\Alert\Ui\Component\Listing\Columns\Store;

/**
 * Class Options
 * @package Magefan\Alert\Ui\Component\Listing\Columns\Store
 */
class Options extends \Magento\Store\Ui\Component\Listing\Column\Store\Options
{
    /**
     * All Store Views value
     */
    const ALL_STORE_VIEWS = '0';

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }
        $this->currentOptions['All Store Views']['label'] = __('All Store Views');
        $this->currentOptions['All Store Views']['value'] = self::ALL_STORE_VIEWS;
        $this->generateCurrentOptions();
        $this->options = array_values($this->currentOptions);
        return $this->options;
    }
}
