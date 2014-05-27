<?php
namespace Application\Entity;

class Option
{
    /**
     * @var OptionType
     */
    protected $type;

    /**
     * @var string
     */
    protected $path;

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
     * @param OptionType         $type
     * @param string             $path
     * @param string|int|decimal $value
     */
    public function __construct(OptionType $type, $path, $value)
    {
        $this->type = $type;
        $this->path = $path;
        $this->setValue($value);
    }

    /**
     * @param string|int|decimal $value
     */
    public function setValue($value)
    {
        switch ($this->type->getName()) {
            case OptionType::STRING:
                $this->stringValue = (string) $value;
                break;

            case OptionType::INTEGER:
                $this->integerValue = (int) $value;
                break;

            case OptionType::DECIMAL:
                $this->decimalValue = (string) $value;
                break;
        }
    }

    /**
     * @return string|int
     */
    public function getValue()
    {
        switch ($this->type->getName()) {
            case OptionType::STRING:
                return $this->stringValue;

            case OptionType::INTEGER:
                return $this->integerValue;

            case OptionType::DECIMAL:
                return $this->decimalValue;
        }
    }
}
