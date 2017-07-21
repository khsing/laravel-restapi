<?php

/**
 * @Author: khsing
 * @Date:   2017-07-21 11:08:17
 * @Last Modified by:   khsing
 * @Last Modified time: 2017-07-21 11:13:13
 */

return [
    "restapi" => [
        'enable_hashids' => true,
        'hashids_salt' => env('RESTAPI_HASHID_SALT', 'your-salt-string'),
        'hashids_length' => env('RESTAPI_HASHID_LEN', 11),
        'hashids_alphabet' => env('RESTAPI_HASHID_ALPHABET', 'abcdefghijklmnopqrstuvwxyz0123456789'),
    ]
];
