<?php

namespace App\Providers;

use App\JWT\Token;
use App\Models\User;
use App\Models\Worklog;
use App\Models\Tag;
use App\Policies\WorklogPolicy;
use App\Policies\TagPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->header('X-Authorization')) {

                Token::setTokenFromString($request->header('X-Authorization'));

                if(!Token::isValid())
                {
                    return null;
                }
                $User = User::find(Token::getToken()->getClaim('uid'));

                return $User;
            }
        });

        Gate::policy(Worklog::class, WorklogPolicy::class);
        Gate::policy(Tag::class, TagPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
    }
}
