<?php

namespace App\Http\Controllers;

use App\Actions\Search\SearchBoardsAndTasksAction;
use App\Http\Requests\SearchRequest;
use App\Traits\HandlesControllerExceptions;

class SearchController extends Controller
{
    use HandlesControllerExceptions;
    public function __construct(
        protected SearchBoardsAndTasksAction $action,
    ) {}
    /**
     * Search index
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(SearchRequest $request)
    {
        return $this->handleActionException(
            fn() => $this->action->handle($request->validated()),
            logMessage: 'Search failed',
            successResponse: fn($result) => view('dashboard.index', $result),
        );
    }
}
