<?php

namespace Whilesmart\UserDevices\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Whilesmart\UserDevices\Interfaces\IDeviceController;
use Whilesmart\UserDevices\Traits\ApiResponse;

class DeviceController extends Controller implements IDeviceController
{
    use ApiResponse;

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required|string',
            'name' => 'nullable|string',
            'type' => 'nullable|string|in:web,mobile',
            'identifier' => 'nullable|string',
            'platform' => 'nullable|string',
        ]);

        $user = $request->user();
        $data = $request->all();
        $data['type'] = $data['type'] ?? 'mobile';
        try {
            $device = $user->devices()->firstOrCreate($data);

            return $this->success($device, __('devices.created'), 201);
        } catch (Exception $err) {
            Log::error($err);

            return $this->failure(__('devices.operation_failed'), 500);
        }
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        try {
            $user = $request->user();
            $device = $user->devices()->find($id);
            if (is_null($device)) {
                return $this->failure(__('devices.not_found'), 404);
            }

            $device->delete();

            return $this->success([], __('devices.deleted'), 200);

        } catch (Exception $err) {
            Log::error($err);

            return $this->failure(__('devices.operation_failed'), 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'token' => 'required|string',
            'name' => 'nullable|string',
            'type' => 'nullable|string|in:web,mobile',
            'identifier' => 'nullable|string',
            'platform' => 'nullable|string',
        ]);

        try {
            $user = $request->user();

            $device = $user->devices()->find($id);
            if (is_null($device)) {
                return $this->failure(__('devices.not_found'), 404);
            }
            $data = $request->all();
            $device->update($data);

            return $this->success($device, __('devices.updated'), 200);

        } catch (Exception $err) {
            Log::error($err);

            return $this->failure(__('devices.operation_failed'), 500);
        }
    }

    public function updateByIdentifier(Request $request, $identifier): JsonResponse
    {
        // Only allow token (and optionally name) to be updated for security
        // Device name, identifier, type and platform cannot change
        $request->validate([
            'token' => 'required|string',
            'name' => 'nullable|string',
        ]);

        try {
            $user = $request->user();

            $device = $user->devices()->where('identifier', $identifier)->first();
            if (is_null($device)) {
                return $this->failure(__('devices.not_found'), 404);
            }

            // $data = $request->validated();
            $data = $request->only(['token', 'name']);
            $device->update($data);

            return $this->success($device, __('devices.updated'), 200);

        } catch (Exception $err) {
            Log::error($err);

            return $this->failure(__('devices.operation_failed'), 500);
        }
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $devices = $user->devices;

        return $this->success($devices, __('devices.retrieved'), 200);
    }
}
