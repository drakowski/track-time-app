<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateEmployeeRequest
{
    private const int FIRST_NAME_AND_LAST_NAME_MAX_LENGTH_CONSTRAINTS = 512;

    public function __construct(
        #[Assert\NotBlank(
            message: 'employee.create.firstNameAndLastName.blankMessage',
        )]
        #[Assert\Length(
            max: self::FIRST_NAME_AND_LAST_NAME_MAX_LENGTH_CONSTRAINTS,
            maxMessage: 'employee.create.firstNameAndLastName.maxMessage',
        )]
        private string $firstNameAndLastName
    ) {
    }

    public function getFirstNameAndLastName(): string
    {
        return $this->firstNameAndLastName;
    }
}
