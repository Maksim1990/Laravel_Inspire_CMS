<?php

namespace App\Providers;

use App\Config\Elastic;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            'partials.sidebar',
            'App\Http\ViewComposers\SidebarComposer'
        );

        view()->composer(
            [
                'website::partials.header_menu',
                'website::partials.header_html',
                'website::partials.footer',
                'website::partials.contact_form',
            ],
            'App\Http\ViewComposers\WebsiteHeaderComposer'
        );

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Elastic::class, function ($app) {
            return new Elastic(
                ClientBuilder::create()
                    ->setLogger(ClientBuilder::defaultLogger(storage_path('logs/elastic.log')))
                    ->build()
            );
        });
    }
}
