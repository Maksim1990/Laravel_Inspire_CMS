<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FooterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            [
                'partials.footer',
                'welcome',
                'welcome',
                'auth.login',
                'auth.register',
                'auth.passwords.reset',
                'auth.passwords.email',
                'website::partials.header_menu'
                ],
            'App\Http\ViewComposers\FooterComposer'
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
