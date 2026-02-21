<?php

namespace Whilesmart\UserDevices\Http\Controllers;

use OpenApi\Attributes as OA;

/**
 * @codeCoverageIgnore
 */
#[OA\OpenApi(
    security: [
        ['bearerAuth' => []],
    ]
)]
#[OA\Info(version: '1.0.0', title: 'User Devices API')]
#[OA\Server(url: 'http://localhost:8000/api', description: 'Local server')]
/**
* Created solely for the purpose of ensuring open api docs can be generated
 */
class Controller
{
}
