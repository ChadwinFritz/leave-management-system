<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\LeaveService;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the LeaveService class to the service container
        $this->app->singleton(LeaveService::class, function ($app) {
            return new LeaveService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('admin.employee_details', function ($view) {
            $userId = Auth::id();  // Or pass it in another way if necessary
            $leaveService = app(LeaveService::class);
            $leaveTypes = \App\Models\LeaveType::all();
            $leaveCounts = [];
    
            foreach ($leaveTypes as $leaveType) {
                $leaveCounts[$leaveType->id] = $leaveService->getEachLeaveCount($userId, $leaveType->id);
            }
    
            $view->with('leaveCounts', $leaveCounts);
        });
    }
}
