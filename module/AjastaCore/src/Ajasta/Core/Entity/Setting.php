<?php
namespace Ajasta\Core\Entity;

class Setting
{
    /**
     * @var SettingType
     */
    protected $type;

    /**
     * @var string
     */
    protected $category;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $stringValue;

    /**
     * @var int|null
     */
    protected $integerValue;

    /**
     * @var decimal|null
     */
    protected $decimalValue;

    /**
     * @param SettingType        $type
     * @param string             $category
     * @param string             $name
     * @param string|int|decimal $value
     */
    public function __construct(SettingType $type, $category, $name, $value)
    {
        $this->type     = $type;
        $this->category = $category;
        $this->name     = $name;
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|int|decimal $value
     */
    public function setValue($value)
    {
        switch ($this->type->getValue()) {
            case SettingType::STRING:
                $this->stringValue = (string) $value;
                break;

            case SettingType::INTEGER:
                $this->integerValue = (int) $value;
                break;

            case SettingType::DECIMAL:
                $this->decimalValue = (string) $value;
                break;
        }
    }

    /**
     * @return string|int|decimal
     */
    public function getValue()
    {
        switch ($this->type->getValue()) {
            case SettingType::STRING:
                return $this->stringValue;

            case SettingType::INTEGER:
                return $this->integerValue;

            case SettingType::DECIMAL:
                return $this->decimalValue;
        }
    }
}
