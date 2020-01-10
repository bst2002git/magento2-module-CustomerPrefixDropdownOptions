<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace IDEC\CustomerPrefixDropdownOptions\Model;

use Magento\Config\Model\Config\Source\Nooptreq as NooptreqSource;


/**
 * Customer Options.
 */
class Options extends \Magento\Customer\Model\Options
{

    /**
     * Retrieve name prefix dropdown options
     *
     * @param null|string|bool|int|StoreInterface $store
     * @return array|bool
     */
    public function getNamePrefixOptions($store = null)
    {
        return $this->prepareNamePrefixSuffixOptions(
            $this->addressHelper->getConfig('prefix_options', $store),
            $this->addressHelper->getConfig('prefix_show', $store) == NooptreqSource::VALUE_OPTIONAL
        );
    }

    /**
     * Retrieve name suffix dropdown options
     *
     * @param null|string|bool|int|StoreInterface $store
     * @return array|bool
     */
    public function getNameSuffixOptions($store = null)
    {
        return $this->prepareNamePrefixSuffixOptions(
            $this->addressHelper->getConfig('suffix_options', $store),
            $this->addressHelper->getConfig('suffix_show', $store) == NooptreqSource::VALUE_OPTIONAL
        );
    }

    /**
     * Unserialize and clear name prefix or suffix options
     *
     * If field is optional, add an empty first option.
     *
     * @param string $options
     * @param bool $isOptional
     * @return array|bool
     */
    private function prepareNamePrefixSuffixOptions($options, $isOptional = false)
    {
        $options = trim($options);
        if (empty($options)) {
            return false;
        }
        $result = [];
        $options = array_filter(explode(';', $options));
        foreach ($options as $value) {
            $value = $this->escaper->escapeHtml(trim($value));
            $result[__($value)->__toString()] = __($value);
        }
        if ($isOptional && trim(current($options))) {
            $result = array_merge([' ' => ' '], $result);
        }

        return $result;
    }
}
