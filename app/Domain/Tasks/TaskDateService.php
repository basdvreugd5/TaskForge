<?php

namespace App\Domain\Tasks;

use RuntimeException;

class TaskDateService
{
    /**
     * Validate date relationships for task creation or updates.
     *
     * @throws \RuntimeException
     */
    public function validateDates(?string $softDueDate, ?string $hardDeadline): void
    {
        if (!$softDueDate || !$hardDeadline) {
            return;
        }

        $soft = strtotime($softDueDate);
        $hard = strtotime($hardDeadline);

        if ($soft > $hard) {
            throw new RuntimeException(
                'The soft due date must not be after the hard deadline.',
            );
        }
    }
}
