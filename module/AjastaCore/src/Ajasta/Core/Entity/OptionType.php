<?php
namespace Ajasta\Core\Entity;

use MabeEnum\Enum;

final class OptionType extends Enum
{
    const STRING  = 'string';
    const INTEGER = 'integer';
    const DECIMAL = 'decimal';
}
