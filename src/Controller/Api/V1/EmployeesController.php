<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\BaseController;
use App\DTO\EmployeeUuidDTO;
use App\Entity\Employee;
use App\Exceptions\AlreadyExistsException;
use App\Repository\EmployeeRepository;
use App\Repository\WorkingTimeRepository;
use App\Request\CreateEmployeeRequest;
use App\Request\RegisterWorkingTimeRequest;
use App\Request\SummariseWorkingTimeRequest;
use App\Services\RegisterWorkingTimeServiceInterface;
use App\Services\SummariseWorkingTimeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Factory\UuidFactory;
use Symfony\Contracts\Translation\TranslatorInterface;
use Throwable;

#[Route(path: '/employees', name: 'employees_', format: 'json')]
class EmployeesController extends BaseController
{
    private const string SERVER_ERROR_WHEN_CREATING_AN_EMPLOYEE = 'SERVER_ERROR_WHEN_CREATING_AN_EMPLOYEE';
    private const string SERVER_ERROR_WHEN_REGISTER_WORKING_TIME = 'SERVER_ERROR_WHEN_REGISTER_WORKING_TIME';
    private const string SERVER_ERROR_WHEN_SUMMARISE_WORKING_TIME = 'SERVER_ERROR_WHEN_SUMMARISE_WORKING_TIME';


    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly EmployeeRepository $employeeRepository
    ) {
    }

    #[Route(path: '', name: 'create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload]
        CreateEmployeeRequest $createEmployeeRequest,
        UuidFactory $uuidFactory,
    ): Response {
        try {
            $uuid = $uuidFactory->create();

            $this->employeeRepository->store(
                new Employee($uuid, $createEmployeeRequest->getFirstNameAndLastName())
            );
            return $this->json(
                $this->prepareDataDTO(
                    new EmployeeUuidDTO($uuid->toRfc4122()),
                    $this->translator->trans('employees.create.success')
                ),
                Response::HTTP_CREATED
            );
        } catch (Throwable) {
            return $this->error(self::SERVER_ERROR_WHEN_CREATING_AN_EMPLOYEE);
        }
    }

    #[Route(path: '/{uuid}/worktimes', name: 'register_working_time', methods: ['POST'])]
    public function registerWorkingTime(
        #[MapRequestPayload]
        RegisterWorkingTimeRequest $registerWorkingTimeRequest,
        RegisterWorkingTimeServiceInterface $registerWorkingTimeService,
        string $uuid
    ): Response {
        try {
            if (!$this->employeeRepository->existsByUuid($uuid)) {
                throw $this->createNotFoundException($this->translator->trans('employees.uuid.notFound'));
            }

            $registerWorkingTimeService->register($uuid, $registerWorkingTimeRequest);

            return $this->json(
                $this->prepareDataDTO(message: $this->translator->trans('employees.registerWorkingTime.success')),
                Response::HTTP_CREATED
            );
        } catch (AlreadyExistsException) {
            return $this->json(
                $this->prepareDataDTO(message: $this->translator->trans('employees.registerWorkingTime.startDateLabel.alreadyExists')),
                Response::HTTP_CONFLICT
            );
        } catch (NotFoundHttpException $notFoundHttpException) {
            throw $notFoundHttpException;
        } catch (Throwable) {
            return $this->error(self::SERVER_ERROR_WHEN_REGISTER_WORKING_TIME);
        }
    }

    #[Route(path: '/{uuid}/worktimes/{period}/summarise', name: 'working_time_summarise', methods: ['GET'])]
    public function summariseWorkingTime(
        string $uuid,
        string $period,
        WorkingTimeRepository $workingTimeRepository,
        SummariseWorkingTimeInterface $summariseWorkingTime
    ): Response {
        try {
            if (!$this->employeeRepository->existsByUuid($uuid)) {
                throw $this->createNotFoundException($this->translator->trans('employees.uuid.notFound'));
            }

            if (!$workingTimeRepository->existsByEmployeeUuidAndStartDateLabel($uuid, $period)) {
                throw $this->createNotFoundException(
                    $this->translator->trans('employees.registerWorkingTime.startDateLabel.notFound')
                );
            }
            $summarise = $summariseWorkingTime->summarise(
                new SummariseWorkingTimeRequest(
                    $uuid,
                    $period,
                    $this->getParameter('monthly_working_hours_quota'),
                    $this->getParameter('hourly_rate'),
                    $this->getParameter('hourly_overtime_rate')
                )
            );

            return $this->json(
                $this->prepareDataDTO($summarise->getAttributes())
            );
        } catch (NotFoundHttpException $notFoundHttpException) {
            throw $notFoundHttpException;
        } catch (Throwable) {
            return $this->error(self::SERVER_ERROR_WHEN_SUMMARISE_WORKING_TIME);
        }
    }
}
