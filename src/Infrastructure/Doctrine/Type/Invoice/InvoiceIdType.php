<?php
declare(strict_types=1);

namespace Ajasta\Infrastructure\Doctrine\Type\Invoice;

use Ajasta\Domain\Invoice\InvoiceId;
use Ajasta\Infrastructure\Doctrine\Type\AbstractIdType;

class InvoiceIdType extends AbstractIdType
{
    /**
     * {@inheritdoc}
     */
    protected function getIdClassName() : string
    {
        return InvoiceId::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Ajasta\Invoice\InvoiceId';
    }
}
