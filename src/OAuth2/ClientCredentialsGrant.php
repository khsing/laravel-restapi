<?php
/**
 * @Author: khsing
 * @Date:   2017-07-20 23:59:51
 * @Last Modified by:   khsing
 * @Last Modified time: 2017-07-21 11:32:02
 */

namespace Khsing\Restapi\OAuth2;

use Laravel\Passport\ClientRepository;
use League\OAuth2\Server\RequestEvent;
use Psr\Http\Message\ServerRequestInterface;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use League\OAuth2\Server\Grant\ClientCredentialsGrant as Grant;

/**
* Custom client credentials
*/
class ClientCredentialsGrant extends Grant
{
    /**
     * {@inheritdoc}
     */
    public function respondToAccessTokenRequest(
        ServerRequestInterface $request,
        ResponseTypeInterface $responseType,
        \DateInterval $accessTokenTTL
    ) {
        // Validate request
        $client = $this->validateClient($request);
        $scopes = $this->validateScopes($this->getRequestParameter('scope', $request, $this->defaultScope));

        // Finalize the requested scopes
        $finalizedScopes = $this->scopeRepository->finalizeScopes($scopes, $this->getIdentifier(), $client);

        // Issue and persist access token
        $accessToken = $this->issueAccessToken($accessTokenTTL, $client, $this->getUserId($request), $finalizedScopes);

        // Send event to emitter
        $this->getEmitter()->emit(new RequestEvent(RequestEvent::ACCESS_TOKEN_ISSUED, $request));

        // Inject access token into response type
        $responseType->setAccessToken($accessToken);

        return $responseType;
    }

    private function getUserId(ServerRequestInterface $request)
    {
        $clientId = $this->getClientId($request);
        $clientInfo = (new ClientRepository())->findActive($clientId);

        return is_null($clientInfo) ? null : $clientInfo->user_id;
    }

    private function getClientId(ServerRequestInterface $request)
    {
        list($basicAuthUser, $basicAuthPassword) = $this->getBasicAuthCredentials($request);

        $clientId = $this->getRequestParameter('client_id', $request, $basicAuthUser);

        return decodeClientIdentifier($clientId);
    }
}
