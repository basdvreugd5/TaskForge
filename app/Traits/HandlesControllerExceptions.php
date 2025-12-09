<?php

namespace App\Traits;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

trait HandlesControllerExceptions
{
    /**
     * Handle a controller action that might throw.
     *
     * @param  callable  $callback  The action logic wrapped in a try/catch.
     * @param  string|null  $errorMessage  Message for UI feedback.
     * @param  string|null  $logMessage  Optional log message context.
     * @param  array  $context  Additional log context.
     */
    protected function handleActionException(
        callable $callback,
        ?string $errorMessage = null,
        ?string $logMessage = null,
        array $context = [],
        ?string $route = null,
        ?array $routeParams = [],
        ?string $successMessage = null,
    ): RedirectResponse {
        try {
            $result = $callback();

            if ($route) {
                $params = empty($routeParams) ? [$result] : $routeParams;

                return to_route($route, $params)
                    ->with('success', $successMessage ?? 'Action completed successfully.');
            }

            return $result instanceof RedirectResponse
                ? $result
                : back()->with('success', $successMessage ?? 'Action completed successfully.');
        } catch (Throwable $e) {
            Log::error($logMessage ?? 'Controller action failed', array_merge($context, [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'route' => request()->path(),
            ]));

            return back()->with('error', $errorMessage ? "{$errorMessage} ({$e->getMessage()})" : $e->getMessage());

        }
    }
}
