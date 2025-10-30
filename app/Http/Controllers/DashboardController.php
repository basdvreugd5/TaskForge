<?php

namespace App\Http\Controllers;

use App\Actions\Dashboard\RetrieveDashboardDataAction;
use App\Http\Requests\DashboardIndexRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard view.
     *
     * @param  \App\Http\Requests\DashboardIndexRequest  $request
     * @param  \App\Actions\Dashboard\RetrieveDashboardDataAction  $action
     * @return \Illuminate\Contracts\View\View
     */
    public function index(DashboardIndexRequest $request, RetrieveDashboardDataAction $action)
    {
        $user = Auth::user();

        $filters = $request->getFilters();

        $data = $action->execute($filters);

        return view('dashboard.index', [
            'user' => $user,
            'boards' => $data['boards'],
            'tasks' => $data['tasks'],
            'filters' => $filters,
        ]);
    }
}
