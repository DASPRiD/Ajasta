<?php
declare(strict_types=1);

namespace Ajasta\Domain;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

trait IdTrait
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function newId() : self
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $id) : self
    {
        return new self(Uuid::fromString($id));
    }

    public static function fromBytes(string $id) : self
    {
        return new self(Uuid::fromBytes($id));
    }

    public function toBytes() : string
    {
        return $this->uuid->getBytes();
    }

    public function __toString() : string
    {
        return $this->uuid->toString();
    }
}
