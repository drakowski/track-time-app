<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\EmployeeConstraintsEnum;
use App\Request\CreateEmployee;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
readonly class Employee
{
    private const int FIRST_NAME_AND_LAST_NAME_MAX_LENGTH = 512;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: UuidType::NAME, unique: true)]
        private Uuid $uuid,
        #[ORM\Column(length: self::FIRST_NAME_AND_LAST_NAME_MAX_LENGTH)]
        private string $firstNameAndLastName,
    ) {
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getFirstNameAndLastName(): string
    {
        return $this->firstNameAndLastName;
    }
}
