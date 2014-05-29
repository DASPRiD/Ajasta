<?php
namespace Ajasta\Application\Entity;

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
     * @var decimal|null
     */
    protected $defaultUnit;

    /**
     * @var decimal|null
     */
    protected $defaultUnitPrice;
}
