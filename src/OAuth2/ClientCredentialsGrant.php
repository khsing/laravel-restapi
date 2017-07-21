<?php
/**
 * @Author: khsing
 * @Date:   2017-07-20 23:59:51
 * @Last Modified by:   khsing
 * @Last Modified time: 2017-07-21 11:32:02
 */

namespace Khsing\Restapi\OAuth2;

use League\OAuth2\Server\Grant\ClientCredentialsGrant as Grant;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laravel\Passport\ClientRepository;

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
        $scopes = $this->validateScopes($this->getRequestParameter('scope', $request));

        // issue AccessToken with user id
        $clientId = $this->getClientId($request);
        $clientRepository = new ClientRepository;
        $clientInfo = $clientRepository->findActive($clientId);
        $userId = is_null($clientInfo) ? null : $clientInfo->user_id;

        // Finalize the requested scopes
        $scopes = $this->scopeRepository->finalizeScopes($scopes, $this->getIdentifier(), $client);

        // Issue and persist access token
        $accessToken = $this->issueAccessToken($accessTokenTTL, $client, $userId, $scopes);

        // Inject access token into response type
        $responseType->setAccessToken($accessToken);

        return $responseType;
    }

    private function getClientId(ServerRequestInterface $request)
    {

        list($basicAuthUser, $basicAuthPassword) = $this->getBasicAuthCredentials($request);

        $clientId = $this->getRequestParameter('client_id', $request, $basicAuthUser);

        return decodeClientIdentifier($clientId);
    }
}
