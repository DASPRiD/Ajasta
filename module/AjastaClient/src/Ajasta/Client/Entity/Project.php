<?php
namespace Ajasta\Client\Entity;

class Project
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $defaultUnit;

    /**
     * @var string|null
     */
    protected $defaultUnitPrice;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getDefaultUnit()
    {
        return $this->defaultUnit;
    }

    /**
     * @param string|null $defaultUnit
     */
    public function setDefaultUnit($defaultUnit)
    {
        $this->defaultUnit = $defaultUnit;
    }

    /**
     * @return string|null
     */
    public function getDefaultUnitPrice()
    {
        return $this->defaultUnitPrice;
    }

    /**
     * @param string|null $defaultUnitPrice
     */
    public function setDefaultUnitPrice($defaultUnitPrice)
    {
        $this->defaultUnitPrice = $defaultUnitPrice;
    }
}
