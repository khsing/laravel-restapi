<?php
/**
 * @Author: khsing
 * @Date:   2017-07-21 00:14:47
 * @Last Modified by:   Guixing Bai
 * @Last Modified time: 2017-07-21 12:44:15
 */
namespace Khsing\Restapi;

use DateInterval;
use Laravel\Passport\Passport;
use Laravel\Passport\Bridge\ScopeRepository;
use League\OAuth2\Server\AuthorizationServer;
use Laravel\Passport\Bridge\PersonalAccessGrant;
use Laravel\Passport\Bridge\AccessTokenRepository;
use Laravel\Passport\PassportServiceProvider as ServiceProvider;

/**
* Custom Passport provider
*/
class OAuth2ServiceProvider extends ServiceProvider
{
    /**
     * Make the authorization service instance.
     *
     * @return \League\OAuth2\Server\AuthorizationServer
     */
    public function makeAuthorizationServer()
    {
        return new AuthorizationServer(
            $this->app->make(OAuth2\Bridge\ClientRepository::class),
            $this->app->make(AccessTokenRepository::class),
            $this->app->make(ScopeRepository::class),
            'file://'.Passport::keyPath('oauth-private.key'),
            app('encrypter')->getKey()
        );
    }


    /**
     * Register the authorization server.
     *
     * @return void
     */
    protected function registerAuthorizationServer()
    {
        $this->app->singleton(AuthorizationServer::class, function () {
            return tap($this->makeAuthorizationServer(), function ($server) {
                $server->enableGrantType(
                    $this->makeAuthCodeGrant(), Passport::tokensExpireIn()
                );

                $server->enableGrantType(
                    $this->makeRefreshTokenGrant(), Passport::tokensExpireIn()
                );

                $server->enableGrantType(
                    $this->makePasswordGrant(), Passport::tokensExpireIn()
                );

                $server->enableGrantType(
                    new PersonalAccessGrant, new DateInterval('P1Y')
                );

                $server->enableGrantType(
                    new OAuth2\ClientCredentialsGrant, Passport::tokensExpireIn()
                );

                if (Passport::$implicitGrantEnabled) {
                    $server->enableGrantType(
                        $this->makeImplicitGrant(), Passport::tokensExpireIn()
                    );
                }
            });
        });
    }
}
