<?php
namespace Ajasta\Invoice\Entity;

use Ajasta\Client\Entity\Client;
use Ajasta\Client\Entity\Project;

class Invoice
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
     * @var Project
     */
    protected $project;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string
     */
    protected $currencyCode;

    /**
     * @var DateTime
     */
    protected $issueDate;

    /**
     * @var DateTime
     */
    protected $dueDate;

    /**
     * @var decimal|null
     */
    protected $discount;

    /**
     * @var decimal|null
     */
    protected $vat;

    /**
     * @var InvoiceItem[]
     */
    protected $items = [];

    /**
     * @return decimal
     */
    public function getItemAmount()
    {
        $total = '0';

        foreach ($this->items as $item) {
            $total = bcadd($total, $item->getAmount(), 2);
        }

        return $total;
    }

    /**
     * @return decimal
     */
    public function getDiscountAmount()
    {
        return bcmul($this->getItemAmount(), bcdiv($this->discount, 100, 2), 2);
    }

    /**
     * @return decimal
     */
    public function getDiscountedAmount()
    {
        return bcsub($this->getItemAmount(), $this->getDiscountAmount(), 2);
    }

    /**
     * @retrun decimal
     */
    public function getVatAmount()
    {
        return bcmul($this->getDiscountedAmount(), bcdiv($this->vat, 100, 2), 2);
    }

    /**
     * @return decimal
     */
    public function getTotalAmount()
    {
        return bcadd($this->getDiscountedAmount(), $this->getVatAmount(), 2);
    }
}
