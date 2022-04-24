<?php

declare(strict_types=1);

namespace CustomSettings\Model\Entity;

use CustomSettings\CustomSettings;
use CustomSettings\SettingTypes\SettingTypeInterface;
use CustomSettings\SettingTypes\SettingTypeFactory;

trait TypesTrait
{
    protected ?SettingTypeInterface $_settingType = null;

    /**
     * @return TypeInterface
     */
    public function typeObject(): SettingTypeInterface
    {
        if (empty($this->_settingType) || $this->_settingType->getTypeName() != $this->type) {
            $type = $this->type ?? CustomSettings::TYPE_STRING;
            $this->_settingType = SettingTypeFactory::get($type);
        }

        return $this->_settingType;
    }

    /**
     * @return mixed
     */
    protected function _getValue(): mixed
    {
        if (empty($this->raw_value)) {
            return null;
        }

        return $this->typeObject()->getValue($this->raw_value);
    }

    /**
     * @return string
     */
    protected function _getStringValue(): string
    {
        if (empty($this->raw_value)) {
            return '';
        }

        return $this->typeObject()->stringValue($this->raw_value);
    }

    protected function _getAlias(): ?string
    {
        if (empty($this->category)) {
            return $this->name;
        }

        return sprintf('%s.%s', $this->category, $this->name);
    }
}
