<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.tailwind');
        
        \Illuminate\Support\Facades\Blade::directive('highlight', function ($expression) {
            return "<?php echo \App\Helpers\HighlightHelper::highlight({$expression}); ?>";
        });
    }
}
