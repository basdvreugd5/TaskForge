<?php

use App\Domain\Tasks\TaskDateService;

beforeEach(function () {
    test()->service = new TaskDateService();
});

it('throws when soft due date is after the hard deadline', function () {
    test()->service->validateDates(
        softDueDate: '2025-12-31',
        hardDeadline: '2025-01-01',
    );
})->throws(RuntimeException::class);

it('allows soft due date equal to hard deadline', function () {
    expect(fn() => test()->service->validateDates(
        softDueDate: '2025-06-01',
        hardDeadline: '2025-06-01',
    ))->not->toThrow(Throwable::class);
});

it('does nothing when one or both dates are missing', function () {
    expect(fn() => test()->service->validateDates(null, '2024-01-01'))
        ->not->toThrow(Throwable::class);

    expect(fn() => test()->service->validateDates('2024-01-01', null))
        ->not->toThrow(Throwable::class);

    expect(fn() => test()->service->validateDates(null, null))
        ->not->toThrow(Throwable::class);
});
