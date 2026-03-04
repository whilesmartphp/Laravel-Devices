<?php

// declare(strict_types=1);

namespace Whilesmart\UserDevices\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

interface IDeviceController
{
    #[OA\Post(
        path: '/api/v1/devices/',
        summary: "Add a new device to the user's profile",
        security: [],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', description: 'Name of the device', type: 'string'),
                    new OA\Property(property: 'token', description: 'FCM Token', type: 'string'),
                    new OA\Property(property: 'type', description: 'Device type. web|mobile', type: 'string'),
                    new OA\Property(property: 'identifier', description: 'Device identifier', type: 'string'),
                    new OA\Property(property: 'platform', description: 'Device platform', type: 'string'),
                ]
            )
        ),
        tags: ['Device'],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ]

    )]
    public function store(Request $request): JsonResponse;

    #[OA\Delete(
        path: '/api/v1/devices/{id}',
        summary: "Removes a new device from the user's profile",
        security: [],
        tags: [
            'Device',
        ],
        parameters: [
            new OA\Parameter(name: 'id', description: 'Device ID', in: 'path', required: true),
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ]
    )]
    public function destroy(Request $request, $id): JsonResponse;

    #[OA\Put(
        path: '/api/v1/devices/{id}',
        summary: "Update a new device on the user's profile",
        security: [],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', description: 'Name of the device', type: 'string'),
                    new OA\Property(property: 'token', description: 'FCM Token', type: 'string'),
                    new OA\Property(property: 'type', description: 'Device type. web|mobile', type: 'string'),
                    new OA\Property(property: 'identifier', description: 'Device identifier', type: 'string'),
                    new OA\Property(property: 'platform', description: 'Device platform', type: 'string'),
                ]
            )
        ),
        tags: ['Device'],
        parameters: [
            new OA\Parameter(name: 'id', description: 'Device ID', in: 'path', required: true),
        ],
        responses: [new OA\Response(response: 200, description: 'OK'),
        ]
    )]
    public function update(Request $request, $id): JsonResponse;

    #[OA\Put(
        path: '/api/v1/devices/identifier/{identifier}',
        summary: "Update a device on the user's profile by identifier (UUID)",
        description: 'Update a device using its identifier (UUID) instead of database ID. Only the token can be updated.',
        security: [],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'token', description: 'FCM Token', type: 'string'),
                ]
            )
        ),
        tags: ['Device'],
        parameters: [
            new OA\Parameter(name: 'identifier', description: 'Device identifier (UUID)', in: 'path', required: true),
        ],
        responses: [new OA\Response(response: 200, description: 'OK'),
        ]
    )]
    public function updateByIdentifier(Request $request, $identifier): JsonResponse;

    #[OA\Get(
        path: '/api/v1/devices/',
        summary: "Get a user's devices",
        security: [],
        tags: [
            'Device',
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK'),
        ]
    )]
    public function index(Request $request): JsonResponse;
}
