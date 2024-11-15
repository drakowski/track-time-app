<?php

declare(strict_types=1);


namespace App\Enum;

enum SummaryDTOAttributeEnum: string
{
    case EMPLOYEE_UUID = 'employeeUuid';
    case OVERTIME_HOURS = 'overtimeHours';
    case STANDARD_HOURS = 'standardHours';
    case STANDARD_RATE = 'standardRate';
    case OVERTIME_RATE = 'overtimeRate';
    case TOTAL_HOURS_AND_MINUTES = 'totalHoursAndMinutes';
    case TOTAL_HOURS = 'totalHours';
    case TOTAL_MINUTES = 'totalMinutes';
    case TOTAL_PAYMENT_FOR_HOURS = 'totalPaymentForHours';
    case STANDARD_PAYMENT_FOR_HOURS = 'standardPaymentForHours';
    case OVERTIME_PAYMENT_FOR_HOURS = 'overtimePaymentForHours';
}
