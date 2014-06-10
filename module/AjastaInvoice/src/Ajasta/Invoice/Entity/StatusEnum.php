<?php
namespace Ajasta\Invoice\Entity;

use MabeEnum\Enum;

final class StatusEnum extends Enum
{
    const DRAFT = 'draft';
    const SENT = 'sent';
    const PAID = 'paid';
}
