<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\WorkingTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class WorkingTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkingTime::class);
    }

    public function store(WorkingTime $workingTime): void
    {
        $this->getEntityManager()->persist($workingTime);
        $this->getEntityManager()->flush();
    }

    public function existsByEmployeeUuidAndStartDateLabel(string $employeeUuid, string $startDateLabel): bool
    {
        $qb = $this->createQueryBuilder('ec');
        $qb->select('count(ec.id)');
        if (preg_match('/^\d{4}-\d{2}$/', $startDateLabel)) {
            $qb->andWhere('SUBSTRING(ec.startDateLabel, 1, 7) = :startDateLabel');
        } else {
            $qb->andWhere('ec.startDateLabel = :startDateLabel');
        }

        $qb->andWhere('ec.employeeUuid = :employeeUuid')
            ->setParameter('startDateLabel', $startDateLabel)
            ->setParameter('employeeUuid', $employeeUuid);

        $result = $qb->getQuery()->getSingleScalarResult();

        return is_int($result) && $result > 0;
    }

    public function findMinStartDateTime(string $startDateLabel, string $employeeUuid): DateTimeInterface
    {
        $qb = $this->createQueryBuilder('ec');
        $qb->select('ec.startDateTime');
        if (preg_match('/^\d{4}-\d{2}$/', $startDateLabel)) {
            $qb->andWhere('SUBSTRING(ec.startDateLabel, 1, 7) = :startDateLabel');
        } else {
            $qb->andWhere('ec.startDateLabel = :startDateLabel');
        }
        $qb
            ->andWhere('ec.employeeUuid = :employeeUuid')
            ->orderBy('ec.startDateTime', 'ASC')
            ->setMaxResults(1)
            ->setParameter('startDateLabel', $startDateLabel)
            ->setParameter('employeeUuid', $employeeUuid);

        return DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            $qb->getQuery()->getSingleScalarResult()
        );
    }

    public function findMaxEndDateTime(string $startDateLabel, string $employeeUuid): DateTimeInterface
    {
        $qb = $this->createQueryBuilder('ec');
        $qb->select('ec.endDateTime');
        if (preg_match('/^\d{4}-\d{2}$/', $startDateLabel)) {
            $qb->andWhere('SUBSTRING(ec.startDateLabel, 1, 7) = :startDateLabel');
        } else {
            $qb->andWhere('ec.startDateLabel = :startDateLabel');
        }

        $qb
            ->andWhere('ec.employeeUuid = :employeeUuid')
            ->orderBy('ec.endDateTime', 'DESC')
            ->setMaxResults(1)
            ->setParameter('startDateLabel', $startDateLabel)
            ->setParameter('employeeUuid', $employeeUuid);


        return DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            $qb->getQuery()->getSingleScalarResult()
        );
    }
}
