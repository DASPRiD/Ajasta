<?php
declare(strict_types=1);

namespace Ajasta\Domain;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractId
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function newInvoiceId() : self
    {
        return new static(Uuid::uuid4());
    }

    public static function fromString(string $id) : self
    {
        return new static(Uuid::fromString($id));
    }

    public function __toString() : string
    {
        return $this->id->toString();
    }
}
