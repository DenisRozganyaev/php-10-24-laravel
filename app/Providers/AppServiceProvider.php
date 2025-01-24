<?php

namespace App\Providers;

use App\Repositories\Contracts\ImagesRepositoryContract;
use App\Repositories\Contracts\ProductsRepositoryContract;
use App\Repositories\ImagesRepository;
use App\Repositories\ProductRepository;
use App\Services\Contracts\FileServiceContract;
use App\Services\FileService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $bindings = [
        ProductsRepositoryContract::class => ProductRepository::class,
        ImagesRepositoryContract::class => ImagesRepository::class,
        FileServiceContract::class => FileService::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
