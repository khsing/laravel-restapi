<?php
/**
 * @Author: khsing
 * @Date:   2017-07-21 11:25:33
 * @Last Modified by:   Guixing Bai
 * @Last Modified time: 2017-07-21 12:45:17
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

function encodeClientIdentifier($clientIdentifier)
{
    if (config('restapi.enable_hashids')) {
        $hashids = new Hashids(
            config('restapi.hashids_salt'),
            config('restapi.hashids_length'),
            config('restapi.hashids_alphabet')
        );
        return $hashids->encode($clientIdentifier);
    }
    return $clientIdentifier;
}
