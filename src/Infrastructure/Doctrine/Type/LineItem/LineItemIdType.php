<?php
declare(strict_types=1);

namespace Ajasta\Infrastructure\Doctrine\Type\LineItem;

use Ajasta\Domain\LineItem\LineItemId;
use Ajasta\Infrastructure\Doctrine\Type\AbstractIdType;

class LineItemIdType extends AbstractIdType
{
    /**
     * {@inheritdoc}
     */
    protected function getIdClassName() : string
    {
        return LineItemId::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Ajasta.LineItem.LineItemId';
    }
}
