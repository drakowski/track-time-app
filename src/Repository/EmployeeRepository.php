<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\ParameterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function store(Employee $employee): void
    {
        $this->getEntityManager()->persist($employee);
        $this->getEntityManager()->flush();
    }

    public function existsByUuid(string $uuid): bool
    {
        $qb = $this->createQueryBuilder('ec');
        $qb->select('count(ec.uuid)')->where($qb->expr()->eq('ec.uuid', ':uuid'))
            ->setParameter(':uuid', Uuid::fromString($uuid)->toBinary(), ParameterType::BINARY);

        return $qb->getQuery()->getSingleScalarResult() > 0;
    }
}