<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class WorkingTime
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    public function __construct(
        #[ORM\Column(length: 36)]
        private readonly string $employeeUuid,
        #[ORM\Column(type: 'datetime')]
        private readonly DateTimeImmutable $startDateTime,
        #[ORM\Column(type: 'datetime')]
        private readonly DateTimeImmutable $endDateTime,
        #[ORM\Column(length: 10)]
        private readonly string $startDateLabel,
        #[ORM\Column(length: 5)]
        private readonly string $totalWorkingHours,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getStartDateTime(): DateTimeImmutable
    {
        return $this->startDateTime;
    }

    public function getEndDateTime(): DateTimeImmutable
    {
        return $this->endDateTime;
    }

    public function getStartDateLabel(): string
    {
        return $this->startDateLabel;
    }

    public function getTotalWorkingHours(): string
    {
        return $this->totalWorkingHours;
    }

    public function getEmployeeUuid(): string
    {
        return $this->employeeUuid;
    }
}
