<?php
namespace Ajasta\Core;

use Zend\Stdlib\AbstractOptions;

class Options extends AbstractOptions
{
    /**
     * @var string[]
     */
    protected $selectableLocales = ['en-US'];

    /**
     * @var string
     */
    protected $defaultLocale = 'en-US';

    /**
     * @var string
     */
    protected $fopPath = 'fop';

    /**
     * @return string[]
     */
    public function getSelectableLocales()
    {
        return $this->selectableLocales;
    }

    /**
     * @param string[] $selectableLocales
     */
    public function setSelectableLocales(array $selectableLocales)
    {
        $this->selectableLocales = $selectableLocales;
    }

    /**
     * @return string
     */
    public function getDefaultLocale()
    {
        return $this->defaultLocale;
    }

    /**
     * @param string $defaultLocale
     */
    public function setDefaultLocale($defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @return string
     */
    public function getFopPath()
    {
        return $this->fopPath;
    }

    /**
     * @param string $fopPath
     */
    public function setFopPath($fopPath)
    {
        $this->fopPath = $fopPath;
    }
}
