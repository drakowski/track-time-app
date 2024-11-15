<?php

declare(strict_types=1);

namespace App\Utils;

use DateTimeInterface;

final class HoursUtils
{
    public static function diffInHours(DateTimeInterface $start, DateTimeInterface $end): int
    {
        $interval = $start->diff($end);
        return (int)(24 * $interval->days + $interval->h + $interval->i / 60);
    }

    public static function diffInMinutes(DateTimeInterface $start, DateTimeInterface $end): int
    {
        $interval = $start->diff($end);
        return $interval->i;
    }

    public static function diffInString(DateTimeInterface $start, DateTimeInterface $end): string
    {
        $interval = $start->diff($end);
        return sprintf('%02d:%02d', $interval->h, $interval->m);
    }
}
