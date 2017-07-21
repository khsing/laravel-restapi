<?php
/**
 * @Author: khsing
 * @Date:   2017-07-21 11:25:33
 * @Last Modified by:   khsing
 * @Last Modified time: 2017-07-21 11:30:33
 */

use Hashids\Hashids;

function decodeClientIdentifier($clientIdentifier)
{
    if (config('restapi.enable_hashids')) {
        $hashids = new Hashids(
        config('restapi.hashids_salt'),
        config('restapi.hashids_length'),
        config('restapi.hashids_alphabet')
        );
        $clientId = $hashids->decode($clientIdentifier);
        if (!empty($clientId)) {
            $clientIdentifier = $clientId[0];
        }
    }
    return $clientIdentifier;
}
