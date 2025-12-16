<?php

use App\Domain\Tasks\ChecklistService;

beforeEach(function () {
    test()->service = new ChecklistService();
});

it('throws an exception when more than 10 checklist items are provided', function () {
    $items = array_fill(0, 11, [
        'title' => 'Item',
        'is_completed' => false,
    ]);

    test()->service->process($items);
})->throws(RuntimeException::class);

it('normalizes checklist items and defaults is_completed to false', function () {
    $items = [
        ['title' => 'First item'],
        ['title' => 'Second item', 'is_completed' => true],
    ];

    $result = test()->service->process($items);

    expect($result)->toBe([
        [
            'title' => 'First item',
            'is_completed' => false,
        ],
        [
            'title' => 'Second item',
            'is_completed' => true,
        ],
    ]);
});

it('returns an empty array when checklist is null', function () {
    $result = test()->service->process(null);

    expect($result)->toBe([]);
});
