<?php

/**
 * @Author: khsing
 * @Date:   2017-07-21 10:54:16
 * @Last Modified by:   Guixing Bai
 * @Last Modified time: 2017-07-21 12:41:17
 */

namespace Khsing\Restapi\OAuth2\Bridge;

use Laravel\Passport\Bridge\Client;
use Laravel\Passport\Bridge\ClientRepository as Repository;

 /**
 * Custom ClientRepository
 */
class ClientRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getClientEntity($clientIdentifier, $grantType = null,
                                    $clientSecret = null, $mustValidateSecret = true)
    {
        $clientIdentifier = decodeClientIdentifier($clientIdentifier);

        return parent::getClientEntity($clientIdentifier, $grantType, $clientSecret, $mustValidateSecret);
    }
}
