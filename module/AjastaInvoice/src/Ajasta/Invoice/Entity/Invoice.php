<?php
namespace Ajasta\Invoice\Entity;

use Ajasta\Client\Entity\Client;
use Ajasta\Client\Entity\Project;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use InvalidArgumentException;
use Zend\Stdlib\ArrayUtils;

class Invoice
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $invoiceNumber;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Project|null
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
     * @var DateTime|null
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
    protected $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * @param string $invoiceNumber
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
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
     * @return Project|null
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project|null $project
     */
    public function setProject(Project $project = null)
    {
        $this->project = $project;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @param string $currencyCode
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @return DateTime
     */
    public function getIssueDate()
    {
        return $this->issueDate;
    }

    /**
     * @param DateTime $issueDate
     */
    public function setIssueDate(DateTime $issueDate)
    {
        $this->issueDate = $issueDate;
    }

    /**
     * @return DateTime|null
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param DateTime|null $dueDate
     */
    public function setDueDate(DateTime $dueDate = null)
    {
        $this->dueDate = $dueDate;
    }

    /**
     * @return decimal|null
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param decimal|null $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    /**
     * @return decimal|null
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * @param decimal|null $vat
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    }

    /**
     * @return InvoiceItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param InvoiceItem[] $items
     */
    public function setItems($items)
    {
        $items = ArrayUtils::iteratorToArray($items, false);

        foreach ($items as $index => $item) {
            if (!$item instanceof InvoiceItem) {
                throw new InvalidArgumentException(sprintf(
                    'Expected InvoiceItem, got %s at index %s',
                    is_object($item) ? get_class($item) : gettype($item),
                    $index
                ));
            }
        }

        foreach ($this->items as $item) {
            if (!in_array($item, $items, true)) {
               $this->items->removeElement($item);
            }
        }

        $position = -1;

        foreach ($items as $item) {
            $item->setInvoice($this);
            $item->setPosition(++$position);

            if (!$this->items->contains($item)) {
                $this->items->add($item);
            }
        }
    }

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
