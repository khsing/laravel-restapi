<?php
/**
 * @Author: Guixing Bai
 * @Date:   2017-07-21 15:35:25
 * @Last Modified by:   Guixing Bai
 * @Last Modified time: 2017-07-21 15:36:19
 */

namespace Khsing\Restapi;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Route;
use Dingo\Api\Auth\Provider\Authorization;

class DingoAuthServiceProvider extends Authorization
{
    public function authenticate(Request $request, Route $route)
    {
        // $this->validateAuthorizationHeader($request);

        return $request->user();
    }

    public function getAuthorizationMethod()
    {
        return 'bearer';
    }
}
