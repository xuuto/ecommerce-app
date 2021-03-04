<?php

namespace App\Providers;

use App\Contract\CategoryContract;
use App\Contract\ProductContract;
use App\Repositories\categoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use App\Contract\AttributeContract;
use App\Repositories\AttributeRepository;
use App\Contract\BrandContract;
use App\Repositories\BrandRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        CategoryContract::class => categoryRepository::class,
        AttributeContract::class => AttributeRepository::class,
        BrandContract::class =>   BrandRepository::class,
        ProductContract::class =>  ProductRepository::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register ()
    {
        foreach ($this->repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot ()
    {
        //
    }
}
