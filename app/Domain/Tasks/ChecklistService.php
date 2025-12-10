<?php

namespace App\Domain\Tasks;

use RuntimeException;

class ChecklistService
{
    /**
     * Validate the checklist (count limits, required structure).
     *
     * @throws \RuntimeException
     */
    public function validate(array $items): void
    {
        if (count($items) > 10) {
            throw new RuntimeException(
                'The checklist cannot have more than 10 items.',
            );
        }
    }

    /**
     * Transform checklist input into a normalized, consistent format.
     */
    public function normalize(array $items): array
    {
        return collect($items)
            ->map(fn($item) => [
                'title' => $item['title'],
                'is_completed' => $item['is_completed'] ?? false,
            ])
            ->toArray();
    }

    /**
     * Validate + normalize as a single step.
     */
    public function process(?array $items): array
    {
        $items = $items ?? [];

        $this->validate($items);

        return $this->normalize($items);
    }
}
