<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function share(Request $request): array
    {
        if ($request->session()->has('errors')) {
            $toast = [
                'message' => 'Проверьте корректность введенных данных.',
                'type' => 'error'
            ];
        } else {
            $toast = $request->session()->get('toast');
        }

        return array_merge(parent::share($request), [
            'shared' => [
                'isAuth' => auth()->check(),
                'userId' => auth()->id(),
                'userName' => auth()->user()?->name,
                'order' => [
                    'statuses' => Order::STATUS_LABELS
                ]
            ],
            'toast' => $toast
        ]);
    }
}
