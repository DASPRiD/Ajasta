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
    const STATUS_DRAFT = 'draft';
    const STATUS_SENT  = 'sent';
    const STATUS_LATE  = 'late';
    const STATUS_PAID  = 'paid';

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
     * @var DateTime|null
     */
    protected $sendDate;

    /**
     * @var DateTime|null
     */
    protected $payDate;

    /**
     * @var string|null
     */
    protected $discount;

    /**
     * @var string|null
     */
    protected $vat;

    /**
     * @var InvoiceItem[]
     */
    protected $items;

    public function __construct()
    {
        $this->items  = new ArrayCollection();
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
     * @return DateTime|null
     */
    public function getSendDate()
    {
        return $this->sendDate;
    }

    /**
     * @param DateTime|null $sendDate
     */
    public function setSendDate(DateTime $sendDate = null)
    {
        $this->sendDate = $sendDate;
    }

    /**
     * @return DateTime|null
     */
    public function getPayDate()
    {
        return $this->payDate;
    }

    /**
     * @param DateTime|null $payDate
     */
    public function setPayDate(DateTime $payDate = null)
    {
        $this->payDate = $payDate;
    }

    /**
     * @return string|null
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param string|null $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    /**
     * @return string|null
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * @param string|null $vat
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
     * @return string
     */
    public function getStatus()
    {
        if ($this->payDate !== null) {
            return self::STATUS_PAID;
        }

        if ($this->dueDate !== null && $this->dueDate < new DateTime()) {
            return self::STATUS_LATE;
        }

        if ($this->sendDate !== null) {
            return self::STATUS_SENT;
        }

        return self::STATUS_DRAFT;
    }

    /**
     * @return string
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
     * @return string
     */
    public function getDiscountAmount()
    {
        return bcmul($this->getItemAmount(), bcdiv($this->discount, 100, 2), 2);
    }

    /**
     * @return string
     */
    public function getDiscountedAmount()
    {
        return bcsub($this->getItemAmount(), $this->getDiscountAmount(), 2);
    }

    /**
     * @return string
     */
    public function getVatAmount()
    {
        return bcmul($this->getDiscountedAmount(), bcdiv($this->vat, 100, 2), 2);
    }

    /**
     * @return string
     */
    public function getTotalAmount()
    {
        return bcadd($this->getDiscountedAmount(), $this->getVatAmount(), 2);
    }
}
